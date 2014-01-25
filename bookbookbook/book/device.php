<?php
include './DB.php';
?>
<html>
<head>
 <meta charset="utf-8">
 <link href="../book_css/bookshelf.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
 <link href="../book_css/allpage.css" rel="stylesheet" type="text/css">
 <title>本の貸し出し管理サイト</title>
 <script>

 function boxCheck(){

  //チェックされた項目を記録する変数
  var str="";
  
  //for文でチェックボックスを１つずつ確認
  for( i=0; i<document.check.length-1; i++ )
  {
    //チェックされているか確認する
    if( document.check.elements[i].checked )
    {
      //変数strが空でない時、区切りのコンマを入れる
      if( str != "" ) str=str+",";
      
      //チェックボックスのvalue値を変数strに入れる
      str=str+document.check.elements[i].value;
    }
  }
  
  //strが空の時、警告を出す
  if( str=="" ){
   alert( "どれか選択してください。" );
   return false;
 }else{
    //alert( str + "が選択されました。" );
    return true;
  }
}

</script>
</head>
<body>
  <?php include'./siteheader.php';?>
  <div class="sitebox">
    <div class = "header">
     <h1>デバイス</h1>
   </div>
   <div class="main">
    <div class = "searchForm">  
      <form class="s" method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <input type="text" name="word" style = "width: 300px;height:35px;">
        <button type="submit" id="searchbutton"><img src="../book_img/search.png"></button>
      </form>
    </div>
    <div class="bigbox">
      <?php include'./leftbar.php';?>
      <div class="list">
        <FORM class ="item_check" METHOD="post" ACTION="confirm.php" NAME="check" onsubmit = "return boxCheck(this)">
          <?php
          
      ?>
      <div class="borrow">
        <input class="borrowbutton" type="submit" value="借りる">
      </div>
    </form>
  </div>
</div>
</div>
<?php include'footer.php';?>
</body>
</html>