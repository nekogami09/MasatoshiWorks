<?php
include './DB.php';
	//前のページ(自分自身)の入力データを変数に持っておきvalueの初期値にする
	$isbnText = @$_POST["isbn"];								//ISBN
	$linkText = @$_POST["link"];								//リンク
	$book_nameText = $_POST["book_name"];				//タイトル
	$authot_nameText = @$_POST["authot_name"];	//著者
	$publisherText = @$_POST["publisher"];			//出版社
	$book_numberText = @$_POST["book_number"];	//冊数
	$imageUrlText = @$_POST["imageUrl"];	//本の画像のURL
	$book_purchaseText = @$_POST["book_purchase"];	//購入費

	//ボタンを押されたときの処理(自分自身のボタン)
	if(isset($_POST['up'])){	//「登録」が押されたとき
		//DBに同じISBNがないかチェック
		$re = mysql_query("SELECT * FROM BOOK WHERE BOOK.ISBN = '$isbnText' ");
		$value=mysql_fetch_assoc($re);
		if(!empty($value)){	//すでに同じISBNが入っていた場合
			//本の冊数を追加
			$sq="UPDATE BOOK SET BOOK_NUMBER=BOOK_NUMBER+'$book_numberText' WHERE ISBN='$isbnText'";
			if(!$result_flag=mysql_query($sq)){
				//データベースに入らなかったときの警告		
				echo '<script type="text/javascript">';
				echo 'alert( "データベースに追加できませんでした" )';
				echo '</script>' ;
				exit;
			}else{
				//リクエストの処理
				reqest($isbnText);
				//本追加画面にとぶ　urlにale=2をいれることで、とんだ先でメッセージがでる
				header("Location:./add_book.php?ale=2");
			}
		}else{	//同じISBNがはいっていなかった
			//本の情報をDBに入れる
			$flag = mysql_query("INSERT INTO  BOOK (ISBN, BOOK_NAME, AUTHOR_NAME, PUBLISHER, LINK, 	BOOK_NUMBER) VALUES ('$isbnText','$book_nameText','$authot_nameText', '$publisherText', '$linkText', '$book_numberText') ");
			if($flag){
				//リクエストの処理
				reqest($isbnText);
				//本追加画面にとぶ　urlにale=1をいれることで、とんだ先でメッセージがでる
				header("Location:./add_book.php?ale=1");
			}else{
				//データベースに入らなかったときの警告		
				echo '<script type="text/javascript">';
				echo 'alert( "データベースに追加できませんでした" )';
				echo '</script>' ;
			}
		}
	}
	?>

	<html>
	<head>
		<meta charset="utf-8">  <!-- 文字コードの設定 -->
		<link href="../book_css/allpage.css" rel="stylesheet" type="text/css">
		<title>本の確認サイト</title>
		<?php
		//リクエストの本の処理
		function reqest($isbnInput){
			//リクエストの本か調べる
			$re = mysql_query("SELECT * FROM BOOK WHERE BOOK.ISBN = '$isbnInput'");	//本のIDを探す
			$value = mysql_fetch_assoc($re);
			$bookId = $value[ID];
			$re2 = mysql_query("SELECT * FROM REQUEST WHERE REQUEST.BOOK_ID = '$bookId' AND REQUEST.STATUS = '0'");	//リクエストに一致する本のIDがリクエスト中か
			$value2 = mysql_fetch_array($re2);
			$re_flag = 0;	//更新履歴でのコメントをかえる
			//リクエストかどうか
			if(!empty($value2)){	//リクエストの本だった場合
				//リクエストのSTATUSと時間を変更する
				$day =  date("Y-m-d H:i:s");	//日にちの取得
				$reqestOk = "UPDATE REQUEST SET ADD_TIME = '$day' WHERE BOOK_ID = '$bookId' AND STATUS = 0";
				$reqestOk2 = "UPDATE REQUEST SET STATUS = 1 WHERE BOOK_ID = '$bookId' AND ADD_TIME = '$day'";
				$re_flag = 1;	//リクエストの本だった
				if(!mysql_query($reqestOk) || !mysql_query($reqestOk2)){
					//データベースに入らなかったときの警告		
					echo '<script type="text/javascript">';
					echo 'alert( "リクエストデータベースを変更できませんでした¥n本は追加されたので戻るを押してください" )';
					echo '</script>' ;
					$re_flag = 0;	//errer
				}
			}

			//更新履歴を追加
			$userId = $_SESSION["USERNAME"];
			$day =  date("Y-m-d H:i:s");	//日にちの取得
			$comment = "";
			if($re_flag){	//リクエストの本
				$comment = "リクエストされていた本 ".$value[BOOK_NAME]." が追加されました。";
			}else{
				$comment = "".$value[BOOK_NAME]." が追加されました。";
			}
			$flag = mysql_query("INSERT INTO  INFO (USER_ID, WRITE_TIME, COMMENT, BOOK_ID,STATUS) VALUES ('$userId','$day','$comment', '$bookId',3) ");
			if(!$flag){
				echo '<script type="text/javascript">';
				echo 'alert( "更新履歴を追加できませんでした。" )';
				echo '</script>' ;
			}
		}
		?>

		<script>
		//ボタンごとに送信先をかえる
		//ボタンををしたら(どれでも)formの設定をする
		function send(){
      var frm=document.form2;				//formのname
      frm.action="./add_book_confirmation.php";	//自分のページにとぶようにする	
      frm.method="post";						//postで送る
      return true;									//trueでボタンが実行される
  }

		//変更ボタンが押されたら
		function send2(){
			var frm=document.form2;				//formのname
			frm.method="post";						//postで送る
    	frm.action="./add_book.php";	//入力ページにとぶ
    	frm.submit();									//ボタンをsubmitにして送るようにする
    } 

    </script>
</head>
<body>
	<?php include'siteheader.php';?>
	<div class="sitebox">
		<div class="header">
			<h1>本の追加確認画面</h1>
		</div>
		<div class="main">
			<!-- 本の情報を入力する欄 -->
			<!--ボタン(どれでも)が押されたらsend()(script)が動く 基本自分のページにとぶように設定している-->
			<FORM NAME = "form2" METHOD="post" ACTION="add_book_confirmation.php" onsubmit="return send(this)"> <!-- postで自分にとばす -->
				<?php
			//欄
			//全部typeがhiddenにして非表示で送るようにしている
				echo '<p><IMG SRC="'.$imageUrlText.'" ></p>';
				echo '<INPUT TYPE="hidden" NAME="imageUrl"  VALUE="'.$imageUrlText.'">';   //<!--画像-->
				echo '<p>●ISBN</p>';
				echo '<p>'.$isbnText.'</p>';
				echo '<input type="hidden" name="isbn" value="'.$isbnText.'">';    //<!-- ISBN(linkにはいる) -->
				echo '<p>●タイトル</p>';
				echo '<p>'.$book_nameText.'</p>';   
				echo '<INPUT TYPE="hidden" NAME="book_name"  VALUE="'.$book_nameText.'">';   //<!-- タイトル用(book_nameにはいる) -->
				echo '<p>●著者名</p>';
				echo '<p>'.$authot_nameText.'</p>';
		  		echo '<input type="hidden" name="authot_name" value="'.$authot_nameText.'"> '; //<!-- 著者用(author_nameにはいる) -->
		  		echo '<p>●出版社</p>';
		  		echo '<p>'.$publisherText.'</p>';
				echo '<input type="hidden" name="publisher" value="'.$publisherText.'">';    //<!-- 出版社(publisherにはいる) -->	
				echo '<p>●楽天ブックス リンク</p>';
				echo '<p>'.$linkText.'</p>';
				echo '<input type="hidden" name="link" value="'.$linkText.'">';    //<!-- リンク(linkにはいる) -->
				echo '<p>●冊数</p>';
				echo '<p>'.$book_numberText.'</p>';
				echo '<input type="hidden" name="book_number" value="'.$book_numberText.'">';  //<!-- 冊数(book_numberにはいる) -->	
				echo '<p>●購入費</p>';
				$purchaseText = "";
				switch ($book_purchaseText) {
					case 0:
						$purchaseText = "未指定";
						break;
					case 1:
						$purchaseText = "実験実習費";
						break;
					case 2:
						$purchaseText = "個人研究費";
						break;
					case 3:
						$purchaseText = "研学研究費";
						break;
					case 4:
						$purchaseText = "情報研研究費";
						break;
					case 5:
						$purchaseText = "谷私費";
						break;
					case 6:
						$purchaseText = "卒業生寄付";
						break;
				}
				echo '<p>'.$purchaseText.'</p>';
				echo '<input type="hidden" name="book_number" value="'.$book_purchaseText.'">';  //<!-- 冊数(book_numberにはいる) -->	
				?>
				<br> 
				<!-- 変更ボタン(name = "change")押されたらsend2()が実行されformのactionを確認ページにしtypeをsubmitにする-->
				<input type="button" value="変更する" name = "change" onClick = "send2()">
				<br><br>
				<input type="submit" value="確認して登録" name = "up"> <!-- 登録ボタン(name = "up") -->
			</form>
		</div>
		<?php include'footer.php';?>
	</div>
</body>
</html>