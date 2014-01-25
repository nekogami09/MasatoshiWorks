<?php
  //ログイン画面
include './DB.php';
  //postが押されたらif文の中へ
	if(isset($_POST["password"])){//パースワード入力欄が空白をはじく
		$user_id = $_POST["user_id"];//入力欄の文字を変数にいれる
		$password = $_POST["password"];

    $error_message_id = "";
    $error_message_psw = "";
    $error_jadge = 0;

    /* 「全角英数字と全角スペース」を全て「半角英数字と半角スペース」に変換 */
    $$user_id = mb_convert_kana($user_id, "as");

    if( preg_match('/[^A-Za-z0-9._@-]+/', $user_id)){
      $user_id = preg_replace('/[^A-Za-z0-9._@-]/', '', $user_id);    /* 指定文字以外を消す */
      $error_message_id = "半角英数字,「-」,「_」,「.」,「@」のみ使用可能";
      $error_jadge = 1;
    }
    if( preg_match('/[^A-Za-z0-9]+/', $password)){
      $password = preg_replace('/[^A-Za-z0-9]/', '', $password);     /* 指定文字以外を消す */
      $error_message_psw = "半角英数字のみ使用可能です";
      $error_jadge = 1;
    }


    //DB内のuser_idとpasswordが入力と一致するときのみ情報取得
    //valueのなかにユーザーの情報が入る
    $re = mysql_query("SELECT * FROM USER WHERE USER.NAME = '$user_id' AND USER.PASS = '$password'");
    $value=mysql_fetch_assoc($re);

    //ログインできたかをチェックする変数
    $error_message = "";

    //情報が取得できた場合if文内へ
		if(!empty($value)){ //valueにユーザー情報がないとき(空のとき)はログインできない
      if( $error_jadge == 0){
        //sesson_idの取得
        session_regenerate_id(TRUE);  //現在のセッションIDを 新しいものと置き換える
        $_SESSION["USERID"] = $value[ID]; 
        $_SESSION["USERNAME"] = $value[NAME];
        //_SESSIONのUSERIDをログインしたものにかえる
       //menuへ飛ぶ
        header("Location:./menu.php");
      }
		}else{//ログインできなかった場合
      if( $error_jadge == 0){
        $error_message = "USERID又はPASSWORDが間違っています";
      }
    }
  }
  ?>

  <html>
  <head>
    <meta charset="utf-8">  <!-- 文字コードの設定 -->
    <link href="../book_css/login.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
    <title>本の貸し出し管理サイト</title>
  </head>
  <body>
    <h1>本の貸し出しサイト</h1>
    <div class = "box">  <!-- css -->
      <h2>ログイン</h2>
      <!-- ログインできなかったときに表示 -->
      <?php
      if( $error_message ){
        print '<p class = "login_miss">'.$error_message.'</p>';
      }
      ?>
      <!-- postで自分に入力されたIDとpassをとばす -->
      <FORM METHOD="post" ACTION="login.php" name = "loginform"> <!-- postで自分にとばす -->
        <p>USERID</p>    
        <INPUT TYPE="text" NAME="user_id"  VALUE="">  <!-- ユーザーIDようのテキストボックスをだす(user_idにはいる) -->
          <?php
          if( $error_message_id ){
            print '<p class = "login_miss">'.$error_message_id.'</p>';
          }
          ?>
          <p>PASSWORD</p>
          <input type="password" name="password" value="">  <!-- ユーザーpassようのpasswordボックスをだす(passwordにはいる) -->
          <?php
          if( $error_message_psw ){
            print '<p class = "login_miss">'.$error_message_psw.'</p>';
          }
          ?>
          <input type="submit" value="Login">  <!-- ログインボタン -->
        </form>
        <!-- ユーザー登録画面を押すとregister.phpにとぶ -->
        <A Href="./register.php">ユーザー登録</A>
      </div>
    </body>
    </html>