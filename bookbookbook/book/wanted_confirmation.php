<?php
include './DB.php';
	//前のページ(自分自身)の入力データを変数に持っておきvalueの初期値にする
	$isbnText = @$_POST["isbn"];								//ISBN
	$linkText = @$_POST["link"];								//リンク
	$book_nameText = $_POST["book_name"];				//タイトル
	$authot_nameText = @$_POST["authot_name"];	//著者
	$publisherText = @$_POST["publisher"];			//出版社
	$imageUrlText = @$_POST["imageUrl"];	//本の画像のURL

	//ボタンを押されたときの処理(自分自身のボタン)
	if(isset($_POST['up'])){	//「登録」が押されたとき
		//DBに同じISBNがないかチェック
		$re = mysql_query("SELECT * FROM BOOK WHERE BOOK.ISBN = '$isbnText' ");
		$value = mysql_fetch_assoc($re);
		//エラーが起きたとき1以外が入る
		$error = 1;
		if(empty($value)){	//本の情報がなかった場合
			//本の情報をDBに入れる
			$bookNumber = 0;
			//本の情報を本棚にいれる
			$flag = mysql_query("INSERT INTO  BOOK (ISBN, BOOK_NAME, AUTHOR_NAME, PUBLISHER, LINK, 	BOOK_NUMBER) VALUES ('$isbnText','$book_nameText','$authot_nameText', '$publisherText', '$linkText', '$bookNumber') ");
			if(!$flag){
				//エラー2
				$error = 2;
			}
		}

		//リクエストテーブルに保存する
		if($error == 1){
			//リクエストは一人一冊まで
			//リクエスト中なものがないかチェック
			$userId = $_SESSION["USERNAME"];	//ユーザーID
			$re = mysql_query("SELECT * FROM  REQUEST WHERE REQUEST.USER_ID = '$userId' AND REQUEST.STATUS = 0 ");
			$value=mysql_fetch_assoc($re);
			if(empty($value)){	//リクエストがなかった場合
				//REQUESTにいれる
				//リクエストしたい本のIDをDBから取得
				$re2 = mysql_query("SELECT * FROM BOOK WHERE BOOK.ISBN = '$isbnText' ");
				$value2 = mysql_fetch_assoc($re2);
				$bookId = $value2[ID];
				$day =  date("Y-m-d H:i:s");	//日にちの取得
				//DBに新しくいれる
				$flag = mysql_query("INSERT INTO  REQUEST (USER_ID,BOOK_ID,REQUEST_TIME,STATUS) VALUES ('$userId','$bookId','$day',0) ");
				//DBに入ったか確認
				if(!$flag){	//
					$error = 2;
				}else{
					//更新履歴を追加
					$userId = $_SESSION["USERNAME"];
					$comment = "".$value2[BOOK_NAME]." がリクエストされました。";
					$flag = mysql_query("INSERT INTO  INFO (USER_ID, WRITE_TIME, COMMENT, BOOK_ID,STATUS) VALUES ('$userId','$day','$comment', '$bookId',4) ");
					if(!$flag){
						echo '<script type="text/javascript">';
						echo 'alert( "更新履歴を追加できませんでした。¥nリクエストはできましたので戻ってください" )';
						echo '</script>' ;
					}	
				}
			}else{	//リクエストがあった場合
				$error = 3;
			}

			//本追加画面にとぶ　urlのale='.$error.'で、とんだ先のメッセージがかわる
			if($error == 1){
				header("Location:./wanted.php?ale=1");
			}else if($error == 2){
				header("Location:./wanted.php?ale=2");
			}else{
				header("Location:./wanted.php?ale=3");
			}
		}
	}
	?>
	<!-- REQUEST.STATUS 0がリクエスト中　1がリクエストにある本を追加　2がリクエスト破棄 -->
	<html>
	<head>
		<meta charset="utf-8">  <!-- 文字コードの設定 -->
		<link href="../book_css/allpage.css" rel="stylesheet" type="text/css">
		<title>本の管理サイト</title>
		<script>
		//ボタンごとに送信先をかえる
		//ボタンををしたら(どれでも)formの設定をする
		function send(){
      var frm=document.form2;				//formのname
      frm.action="./wanted_confirmation.php";	//自分のページにとぶようにする	
      frm.method="post";						//postで送る
      return true;									//trueでボタンが実行される
  }

		//変更ボタンが押されたら
		function send2(){
			var frm=document.form2;				//formのname
			frm.method="post";						//postで送る
    	frm.action="./wanted.php";	//入力ページにとぶ
    	frm.submit();									//ボタンをsubmitにして送るようにする
    } 

    </script>
</head>
<body>
	<?php include'siteheader.php';?>
	<div class="sitebox">
		<div class="header">
			<h1>リクエスト本の確認画面</h1>
		</div>
		<div class="main">
			<!-- 本の情報を入力する欄 -->
			<!--ボタン(どれでも)が押されたらsend()(script)が動く 基本自分のページにとぶように設定している-->
			<FORM NAME = "form2" METHOD="post" ACTION="wanted_confirmation.php" onsubmit="return send(this)"> <!-- postで自分にとばす -->
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
				?>
				<br> 
				<!-- 変更ボタン(name = "change")押されたらsend2()が実行されformのactionを確認ページにしtypeをsubmitにする-->
				<input type="button" value="変更する" name = "change" onClick = "send2()">
				<br><br>
				<input type="submit" value="リクエストする" name = "up"> <!-- 登録ボタン(name = "up") -->
			</form>
		</div>
		<?php include'footer.php';?>
	</div>
</body>
</html>