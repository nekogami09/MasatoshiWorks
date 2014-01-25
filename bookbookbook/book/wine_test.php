<?php
  //var_dump($_POST["url"]);
if(isset($_POST["url"])){
  $url = "http://www.google.co.jp/searchbyimage?image_url=".$_POST["url"];
  header("Location:$url");
}
?>

<html>
<head>
  <meta charset="utf-8">  <!-- 文字コードの設定 -->
  <link href="../book_css/login.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
  <title>ワイン</title>


</head>
<body>
  <h1>ワイン</h1>

  <!-- postで自分に入力されたIDとpassをとばす -->
  <p>USERID</p>    
  <FORM METHOD="post" ACTION="wine_test.php" > <!-- postで自分にとばす -->
    <INPUT TYPE="text" NAME="url"  VALUE="">  <!-- ユーザーIDようのテキストボックスをだす(user_idにはいる) -->
      <input type='file' name='fname'>
      <input type='submit'value='upload'>
    </form>
    <!-- ユーザー登録画面を押すとregister.phpにとぶ -->
    <A Href="./register.php">ユーザー登録</A>

  </body>
  </html>