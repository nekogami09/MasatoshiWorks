<!--ログアウト画面-->
<?php
include 'DB.php';

//ログアウト画面にきたときSESSIONをみてログインしてきたかを判断
if (isset($_SESSION["USERID"])) { //SESSIONが空じゃなかったら
  $errorMessage = "ログアウトしました。";
}
else {        //SESSIONが空なら
  $errorMessage = "セッションがタイムアウトしました。";
}
// セッション変数のクリア
$_SESSION = array();
// クッキーの破棄
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
    );
}
// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="../book_css/login.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
  <title>本の管理サイト</title>
</head>
<body>
  <div><?php echo '<p class="error">'.$errorMessage.'</p>'; ?></div>
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