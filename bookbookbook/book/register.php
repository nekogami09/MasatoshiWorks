<?php 
include './DB.php';

if(isset($_POST["password"])){
  $user_id = $_POST["user_id"];
  $password = $_POST["password"];
  $re_password = $_POST["re_password"];

  $error_message_id = "";
  $error_message_psw = "";
  $error_jadge = 0;
  
  /* 「全角英数字と全角スペース」を全て「半角英数字と半角スペース」に変換 */
  $$user_id = mb_convert_kana($user_id, "as");

  if( preg_match('/[^A-Za-z0-9._@-]+/', $user_id)){
    $user_id = preg_replace('/[^A-Za-z0-9._@-]/', '', $user_id);      /* 指定文字以外を消す */
    $error_message_id = "半角英数字,「-」,「_」,「.」,「@」のみ使用可能";
    $error_jadge = 1;
  }
  if( preg_match('/[^A-Za-z0-9]+/', $password)){
    $password = preg_replace('/[^A-Za-z0-9]/', '', $password);    /* 指定文字以外を消す */
    $error_message_psw = "半角英数字のみ使用可能です";
    $error_jadge = 1;
  }
  if( preg_match('/[^A-Za-z0-9]+/', $repassword)){
    $repassword = preg_replace('/[^A-Za-z0-9]/', '', $repassword);    /* 指定文字以外を消す */
    $error_message_psw = "半角英数字のみ使用可能です";
    $error_jadge = 1;
  }

  $day =  date("Y-m-d H:i:s");
  $re = mysql_query("SELECT * FROM USER WHERE USER.NAME = '$user_id' ");
  $value=mysql_fetch_assoc($re);

  // ユーザー登録できたかをチェックする変数
  $error_message = "";

  if(!empty($value)){
    if( $error_jadge == 0){
      $error_message = 'USERIDが重複されています';
    }
  }elseif($password != $re_password){
    if( $error_jadge == 0){
      $error_message = 'PASSWORDが一致していません';
    }
  }else{
    // $error_message = 'ユーザーIDが重複されています。';
    if( $error_jadge == 0){
      mysql_query("INSERT INTO  USER (NAME,PASS,CREATED) VALUES ('$user_id','$password','$day') ");
      header("Location:./login.php");
    }
  }
}
?>
<html>

<head>
  <meta charset="utf-8">
  <link href="../book_css/register.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
  <title>登録ページ</title>
  <SCRIPT language="JavaScript">
  <!--
    // 未入力項目をチェックする
    function chValie() {
      // 入力必須項目（「,」で区切って追加可能）
      ess = new Array("user_id","password");
      for(i=0; i<ess.length; i++) {
        console.log(document.nForm.elements[ess[i]].value);
        txt = document.nForm.elements[ess[i]].value;
        if(txt == "") {
          alert("未入力項目があります");
          return false;
        }
      }
      return true;
    }

    </script>
  </head>
  <body>
    <h1>本の貸し出しサイト</h1>

    <div class = "box">  <!-- css -->
      <h2>ユーザー登録</h2>
      <!-- ログインできなかったときに表示 -->
      <?php
      if( $error_message ){
        print '<p class = "login_miss">'.$error_message.'</p>';
      }
      ?>

      <p>USERID</p>
      <FORM METHOD="post" name="nForm" ACTION="register.php" onSubmit="return chValie()"> 
        <input type="text" name="user_id">
        <p class = "input_id">※ Gmailアドレス</p>
        <?php
        if( $error_message_id ){
          print '<p class = "login_miss">'.$error_message_id.'</p>';
        }
        ?>
        <p>PASSWORD</p>
        <input type="password" name="password">
        <p class = "input_psw">※ 半角英数
          <?php
          if( $error_message_psw ){
            print '<p class = "login_miss">'.$error_message_psw.'</p>';
          }
          ?>
          <p>Re-type PASSWORD</p>
          <input type="password" name="re_password">
          <?php
          if( $error_message_psw ){
            print '<p class = "login_miss">'.$error_message_psw.'</p>';
          }
          ?>
          <input type="submit" value="登録">
        </form>
        <br>
        <a href="./login.php">戻る</a>
      </div>

    </body>
    </html>