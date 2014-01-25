<?php
include'DB.php';
mb_language("Japanese");
mb_internal_encoding("UTF-8");
list($user,$book) = split('[$]',$_GET["send"]);
if(isset($_POST["mail"])){
  if (!mb_send_mail($_POST["to"], $_POST["subject"], $_POST["message"], "From: " . $_POST["address"])) {
      $confrim="送信できませんでした";
    exit("error");
  }else{
    $confirm="送信できました";
  }
}
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link href="../book_css/allpage.css" rel="stylesheet" type="text/css">
 <title>本の管理サイト</title>
</head>
<body>
  <?php include'siteheader.php';?>
  <div class="sitebox">
    <div class="header">
      <h1>返却メール</h1>
    </div>
  <div class="main" align="center">
    <?php echo '<p>'.$confirm.'</p>'; ?>
    <form action="mail.php" method="post" >
      <TABLE>
        <TR>
         <TD bgcolor="#9bb0f9">■件名</TD>
         <TD width="308"><INPUT type="text" size="72" name="subject" value="返却のお願い"></TD>
       </TR>
       <TR>
        <TD bgcolor="#9bb0f9">■相手のメールアドレス</TD>
        <TD width="308"><INPUT type="text" size="72" name="to" value="<?php echo $user; ?>"></TD>
      </TR>
      <TR>
        <TD bgcolor="#9bb0f9">■自分のメールアドレス</TD>
        <TD width="308"><INPUT type="text" size="72" name="address" value="<?php echo $_SESSION[USERNAME]; ?>"></TD>
      </TR>
      <TR>
        <TD bgcolor="#9bb0f9" height="135">■内容</TD>
        <TD width="308" height="135">
         <TEXTAREA name="message" cols="60" rows="10"><?php echo $user.'さん';?>&#13;<?php echo 'タイトル:'.$book.'を至急返却お願いします';?></TEXTAREA>
       </TD>
     </TR>
     <TR>
      <TD colspan="2" align="center" width="308">
        <input type="submit" name="mail" value="　メール送信　">
      </TD>
    </TR>

  </TABLE>
</form>
</div>
<?php include'footer.php';?>
</div>
</body>
</html>