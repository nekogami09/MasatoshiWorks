<?php
include './DB.php';
include './api_search.php'; //関数呼び出しより手前に記述する



	//確認画面からとんできたときにurlにaleの値が入っている
	//aleに値が入っていたらメッセージを出す
	if($_GET['ale'] == 1) {		//本の追加
		//scriptでメーセージを出す
		echo '<script type="text/javascript">' ;
		echo 'alert( "登録しました!" )' ;
		echo '</script>' ;
	}else if($_GET['ale'] == 2){	//本の冊数追加
		echo '<script type="text/javascript">' ;
		echo 'alert( "同じISBNの本の情報があったので冊数を追加しました!" )' ;
		echo '</script>' ;
	}

	//前のページ(自分自身)の入力データを変数に持っておきvalueの初期値にする
	$isbnText = @$_POST["isbn"];								//ISBN
	$linkText = @$_POST["link"];								//リンク
	$book_nameText = @$_POST["book_name"];			//タイトル
	$authot_nameText = @$_POST["authot_name"];	//著者
	$publisherText = @$_POST["publisher"];			//出版社
	$book_numberText = @$_POST["book_number"];	//冊数
	$imageUrlText = @$_POST["imageUrl"];	//本の画像のURL

	//ボタンを押されたときの処理(自分自身のボタン)
	if(isset($_POST['acquisition'])){	//「情報取得」が押されたとき
		if($_POST["isbn"] != ""){	//ISBNが入力されていたら
			//amazonのISBNを利用して情報を取得する
			//まだ登録中
			//入力されtISBNの判定
			if(preg_match("/^[0-9]+$/", $_POST["isbn"])){
				//楽天ブックスから情報をとる
				$items = array();	//情報を入れる配列
				$reTest = apiSearch($_POST["isbn"], $items);	//本の情報が配列の中に入る(引数 ISBN, 配列)

				//情報を入れる
				if($reTest){
					$book_nameText = $items[1]['title'];				//タイトル
					$authot_nameText = $items[1]['author'];	//著者
					$publisherText = $items[1]['publisherName'];			//出版社
					$linkText = $items[1]['itemUrl'];	//リンク
					$book_numberText = 1;
					$imageUrlText = $items[1]['mediumImageUrl'];
				}else{
					//警告メッセージを出す
					echo '<script type="text/javascript">';
					echo 'alert( "みつかりませんでした" )';
					echo '</script>' ;
				}
			}else{	//数字以外が入力されていたら
				//警告メッセージを出す
				echo '<script type="text/javascript">';
				echo 'alert( "ISBNコードは半角数字のみです!" )';
				echo '</script>' ;
			}
		}else{	//ISBNが空欄だったら
			//警告メッセージを出す
			echo '<script type="text/javascript">';
			echo 'alert( "ISBNコードを入力してください!" )';
			echo '</script>' ;
		}
	}
	?>

	<html>
	<head>
		<meta charset="utf-8">  <!-- 文字コードの設定 -->
		<title>本の管理サイト</title>

		<!-- jQuery -->
		<script type="text/javascript" src="../book_js/jquery-1.2.6.js"></script>

		<!-- ui tabs.js -->
		<script type="text/javascript" src="../book_js/ui.core.js"></script>
		<script type="text/javascript" src="../book_js/ui.tabs.js"></script>
		<script type="text/javascript" src="./smoothscroll.js"></script> 
		<link href="../book_css/add_book.css" rel="stylesheet" type="text/css" />
		<link href="../book_css/allpage.css" rel="stylesheet" type="text/css" />

		<!-- タブのデフォルト -->
		<script type="text/javascript">
		$(function() {
			$('#ui-tab > ul').tabs();
		});
		</script>

		<script>
		//ボタンごとに送信先をかえる
		//ボタンををしたら(どれでも)formの設定をする
		function send(){
      var frm=document.form1;				//formのname
      frm.action="./add_book.php";	//自分のページにとぶようにする	
      frm.method="post";						//postで送る
      return true;									//trueでボタンが実行される
  }

    //タブ2
    function send2(){
      var frm=document.form2;				//formのname
      frm.action="./add_book.php";	//自分のページにとぶようにする	
      frm.method="post";						//postで送る
      return true;									//trueでボタンが実行される
  }

    //登録ボタンが押されたらformの設定をする
    function registration(){
    	var frm=document.form1;										//formのname
    	//テキストボックス内に空欄がないか確認
    	flag = 0; //空欄があるときはフラグをたてる
    	for(i = 0; i < 6; i++){
    		//２番目と３番目のボタンのelementsはとばすようにする
    		j = 0;
    		if(i > 0) j = 2;
    		if(frm.elements[i+j].value == ""){
    			//空の場所の字のいろをかえる
    			flag = 1;
    			document.getElementById("tab1_text" + i).style.color = "red";
    			document.getElementById("tab1_text" + i).style.backgroundColor = "yellow";
    		}else{
    			//色を戻す
    			document.getElementById("tab1_text" + i).style.color = "";
    			document.getElementById("tab1_text" + i).style.backgroundColor = "";
    		}
    	}

    	//フラグがたっているときは空白がある
    	if(flag){ 
    		alert( "空欄があります!" );
    	}else{
    		//ISBNが半角数字だけで書かれているか
    		if(frm.isbn.value.match(/[^0-9]+/)){
    			//テキストの色を変える
    			document.getElementById('tab1_text0').style.color = "red";
    			document.getElementById('tab1_text0').style.backgroundColor = "yellow";
    			alert( "ISBNコードは半角数字のみです!" );
    		}else{	//書かれているとき
					//確認を呼びかける
					//alert( "入力を確認してください!" );
		    	frm.method="post";												//postで送る
		    	frm.action="./add_book_confirmation.php";	//確認ページにとぶ
		    	frm.submit();															//ボタンをsubmitにして送るようにする
					//テキストの色を戻す
					document.getElementById('tab1_text1').style.color = "";
					document.getElementById('tab1_text1').style.backgroundColor = "";
				}
			}
		}

    //タブ2
    function registration2(){
    	var frm=document.form2;										//formのname
    	//テキストボックス内に空欄がないか確認
    	flag = 0; //空欄があるときはフラグをたてる
    	for(i = 0; i < 6; i++){
    		//1のボタンのelementsはとばすようにする
    		if(frm.elements[i+1].value == ""){
    			//空の場所の字のいろをかえる
    			flag = 1;
    			document.getElementById("tab2_text" + i).style.color = "red";
    			document.getElementById("tab2_text" + i).style.backgroundColor = "yellow";
    		}else{
    			//色を戻す
    			document.getElementById("tab2_text" + i).style.color = "";
    			document.getElementById("tab2_text" + i).style.backgroundColor = "";
    		}
    	}

    	//フラグがたっているときは空白がある
    	if(flag){   	
    		alert( "空欄があります!" );
    	}else{
	    	//ISBNが半角数字だけで書かれているか
	    	if(frm.isbn.value.match(/[^0-9]+/)){
    			//テキストの色を変える
    			document.getElementById('tab2_text0').style.color = "red";
    			document.getElementById('tab2_text0').style.backgroundColor = "yellow";
    			alert( "ISBNコードは半角数字のみです!" );
    		}else{	//書かれているとき
					//確認を呼びかける
					//alert( "入力を確認してください!" );
		    	frm.method="post";												//postで送る
		    	frm.action="./add_book_confirmation.php";	//確認ページにとぶ
		    	frm.submit();															//ボタンをsubmitにして送るようにする
		    	//テキストの色を戻す
		    	document.getElementById('tab2_text1').style.color = "";
		    	document.getElementById('tab2_text1').style.backgroundColor = "";
		    }
		}
	}

    //リセットボタン(タブ１)
    function clearText(){
    	//リセットしていいか確認を出す
    	flag = confirm("リセットしますか?");
    	if(flag){
				//確認で「ok」がが押されたら格テキストのvalueを空にする
				var frm=document.form1;										//formのname
				frm.isbn.value = "";
				frm.link.value = "";
				frm.book_name.value = "";
				frm.authot_name.value = "";
				frm.publisher.value = "";
				frm.book_number.value = "";
				frm.imageUrl.value = "";

				frm.method="post";												//postで送る
	    	frm.action="./add_book.php";	//自分
	    	frm.submit();															//ボタンをsubmitにして送るようにする
	    }
	}

    //リセットボタン2(タブ2)
    function clearText2(){
    	//リセットしていいか確認を出す
    	flag = confirm("リセットしますか?");
    	if(flag){
				//確認で「ok」がが押されたら格テキストのvalueを空にする
				var frm=document.form2;										//formのname
				frm.isbn.value = "";
				frm.link.value = "";
				frm.book_name.value = "";
				frm.authot_name.value = "";
				frm.publisher.value = "";
				frm.book_number.value = "";
				frm.imageUrl.value = "";

				//frm.method="post";												//postで送る
	   		//frm.action="./add_book.php";	//確認ページにとぶ
	   		//frm.submit();															//ボタンをsubmitにして送るようにする
	   	}
	   }

	   </script>
	</head>
	<body>
		<?php include'./siteheader.php';?>
		<!-- タイトル -->
		<div class ="sitebox">
			<div class = "header">
				<h1>本の追加</h1>
			</div>

			<!-- タブの設定 -->
			<div class="main">
				<div id="ui-tab">
					<ul>	<!-- タブの表示文字 -->
						<li><a href="#fragment-1"><span>ISBNで取得</span></a></li>
						<li><a href="#fragment-2"><span>手打ち入力</span></a></li>
					</ul>

					<!-- タブ１の内容 -->
					<!-- 情報入力欄はかけないようにする -->
					<div id="fragment-1">
						<!-- 本の情報を入力する欄 -->
						<!--ボタン(どれでも)が押されたらsend()(script)が動く 基本自分のページにとぶように設定している-->
						<FORM NAME="form1"　METHOD="post" ACTION="add_book.php" onsubmit="return send(this)"> 
							<?php
					//欄
							echo '<p><span id="tab1_text0">●ISBN</span>　　　※ISBNを入力して「情報取得」を押すと楽天ブックスから本の情報を取得します</p>';
					echo '<input type="text" name="isbn" value="'.$isbnText.'" required>';    //<!-- ISBN(linkにはいる) -->
					echo '<input type="submit" value="情報取得" name = "acquisition">';	//<!-- 取得ボタン(neme = acquisition) -->
					echo '<p><IMG SRC="'.$imageUrlText.'" ></p>';
					echo '<INPUT TYPE="hidden" NAME="imageUrl"  VALUE="'.$imageUrlText.'">';   //<!--画像-->
					echo '<p><span id="tab1_text1">●タイトル</span></p>';
					echo '<p>'.$book_nameText.'</p>';  
					echo '<INPUT TYPE="hidden" NAME="book_name"  VALUE="'.$book_nameText.'">';   //<!-- タイトル用(book_nameにはいる) -->
					echo '<p><span id="tab1_text2">●著者名</span></p>';
					echo '<p>'.$authot_nameText.'</p>';
				 	echo '<input type="hidden" name="authot_name" value="'.$authot_nameText.'"> '; //<!-- 著者用(author_nameにはいる) -->
				 	echo '<p><span id="tab1_text3">●出版社</span></p>';
				 	echo '<p>'.$publisherText.'</p>';
					echo '<input type="hidden" name="publisher" value="'.$publisherText.'">';    //<!-- 出版社(publisherにはいる) -->	
					echo '<p><span id="tab1_text4">●楽天ブックス リンク</span></p>';
					echo '<p>'.$linkText.'</p>';
					echo '<input type="hidden" name="link" value="'.$linkText.'">';    //<!-- リンク(linkにはいる) -->
					echo '<p><span id="tab1_text5">●冊数</span></p>';
						//
					echo '<select name = "book_number">';
					echo '<option value = '.$book_numberText.'>'.$book_numberText.'';
					echo '<option value = 1>1';
					echo '<option value = 2>2';
					echo '<option value = 3>3';
					echo '<option value = 4>4';
					echo '<option value = 5>5';
					echo '</select>';

					echo '<p><span id="tab1_text6">●購入費</span></p>';
					echo '<select name = "book_purchase">';
					//echo '<option value = '.$book_numberText.'>'.$book_numberText.'';
					echo '<option value = 0>未指定';
					echo '<option value = 1>実験実習費';
					echo '<option value = 2>個人研究費';
					echo '<option value = 3>研学研究費';
					echo '<option value = 4>情報研研究費';
					echo '<option value = 5>谷私費';
					echo '<option value = 6>卒業生寄付';
					echo '</select>';
					// echo '<input type="text" name="book_number" value="'.$book_numberText.'">';  //<!-- 冊数(book_numberにはいる) -->	
					?>
					<br><br>
					<input type="button" value="リセット" name = "textClear" onClick = "clearText()">		<!-- クリアボタン(name = "textClear") -->
					<!--登録ボタン(name="up")押されたらsend2()が実行されformのactionを確認ページにしtypeをsubmitにする-->
					<input type="button" value="確認画面へ" name = "up" onClick = "registration()"> 
				</form>
			</div>

			<!-- タブ２の内容 -->
			<div id="fragment-2">
				<!-- 本の情報を入力する欄 -->
				<!--ボタン(どれでも)が押されたらsend()(script)が動く 基本自分のページにとぶように設定している-->
				<FORM NAME="form2"　METHOD="post" ACTION="add_book.php" onsubmit="return send2(this)"> 
					<?php
			//欄
					echo '<p><IMG SRC="'.$imageUrlText.'" ></p>';
					echo '<INPUT TYPE="hidden" NAME="imageUrl"  VALUE="'.$imageUrlText.'">';   //<!--画像-->
					echo '<p><span id="tab2_text0">●ISBN</span></p>';
					echo '<input type="text" name="isbn" value="'.$isbnText.'" required>';    //<!-- ISBN(linkにはいる) -->
					echo '<p><span id="tab2_text1">●タイトル</span></p>';   
					echo '<INPUT TYPE="text" NAME="book_name"  VALUE="'.$book_nameText.'" required>';   //<!-- タイトル用(book_nameにはいる) -->
					echo '<p><span id="tab2_text2">●著者名</span></p>';
		  		echo '<input type="text" name="authot_name" value="'.$authot_nameText.'" required> '; //<!-- 著者用(author_nameにはいる) -->
		  		echo '<p><span id="tab2_text3">●出版社</span></p>';
					echo '<input type="text" name="publisher" value="'.$publisherText.'" required>';    //<!-- 出版社(publisherにはいる) -->	
					echo '<p><span id="tab2_text4">●楽天ブックス リンク</span></p>';
					echo '<input type="text" name="link" value="'.$linkText.'" required>';    //<!-- リンク(linkにはいる) -->
					echo '<p><span id="tab2_text5">●冊数</span></p>';
				//
					echo '<select name = "book_number">';
					echo '<option value = '.$book_numberText.'>'.$book_numberText.'';
					echo '<option value = 1>1';
					echo '<option value = 2>2';
					echo '<option value = 3>3';
					echo '<option value = 4>4';
					echo '<option value = 5>5';
					echo '</select>';

					echo '<p><span id="tab1_text6">●購入費</span></p>';
					echo '<select name = "book_purchase">';
					//echo '<option value = '.$book_numberText.'>'.$book_numberText.'';
					echo '<option value = 0>未指定';
					echo '<option value = 1>実験実習費';
					echo '<option value = 2>個人研究費';
					echo '<option value = 3>研学研究費';
					echo '<option value = 4>情報研研究費';
					echo '<option value = 5>谷私費';
					echo '<option value = 6>卒業生寄付';
					echo '</select>';
					// echo '<input type="text" name="book_number" value="'.$book_numberText.'">';  //<!-- 冊数(book_numberにはいる) -->	
					?>
					<br><br>
					<input type="button" value="リセット" name = "textClear" onClick = "clearText2()">		<!-- クリアボタン(name = "textClear") -->
					<!--登録ボタン(name="up")押されたらsend2()が実行されformのactionを確認ページにしtypeをsubmitにする-->
					<input type="button" value="確認画面へ" name = "up" onClick = "registration2()"> 
				</form>
			</div>

		</div>
	</div>
	<?php include'footer.php'; ?>
</div>
</body>
</html>