<?php
include './DB.php';
include './api_search.php';
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
     <h1>本棚</h1>
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
          include'./paging.php';
          echo '<ul class="item_list">';
          $count=0;
          while($value=mysql_fetch_assoc($re)){
            $items = array();
            $reTest = apiSearch($value[ISBN], $items);
            $imageUrlText = $items[1]['largeImageUrl'];
            $num = $value[BOOK_NUMBER] - $value[RENT_NUM];
            echo '<li class="item">';
            if($num >0){
              echo '<div class="item_check">';
              echo '<input type="checkbox" name="book[]" value="'.$value[ID].'">';
              echo '</div>';
              echo '<div class="item_img">';
              echo '<IMG SRC="'.$imageUrlText.'" style="height:150px;width:130px;">';
              echo '</div>';
              echo '<div class="item_cont">';
              echo '<div class="item_title">';
              echo '<a href="./detail.php?isbn='.$value[ISBN].'">'.$value[BOOK_NAME].'</a>';
              echo '</div>';
              echo '<div class="item_info">';
              echo '<ul class="info_list">';
              echo '<li class="author">著者：'.$value[AUTHOR_NAME].'</li>';
              echo '<li class="publisher">出版社：'.$value[PUBLISHER].'</li>';
              echo '</ul>';
              echo '</div>';
              echo '<div class="item_data">';
              echo '<ul class="data_list">';
              echo '<li class="book_num">在庫：'.$num.'</li>';
              echo '<li class ="book_count">貸出総回数：'.$value[BOOK_COUNTER].'</li>';
              echo '</ul>';
              echo '</div>';
              echo '</div>';
              echo '</li>';
            }else{
              echo '<div class="non_check">';
              echo '<div class="item_img">';
              echo '<IMG SRC="'.$imageUrlText.'" style="height:150px;width:130px;">';
              echo '</div>';
              echo '<div class="item_cont">';
              echo '<div class="item_title">';
              echo '<a href="./detail.php?isbn='.$value[ISBN].'">'.$value[BOOK_NAME].'</a>';
              echo '</div>';
              echo '<div class="item_info">';
              echo '<ul class="info_list">';
              echo '<li class="author">著者：'.$value[AUTHOR_NAME].'</li>';
              echo '<li class="publisher">出版社：'.$value[PUBLISHER].'</li>';
              echo '</ul>';
              echo '</div>';
              echo '<div class="item_data">';
              echo '<ul class="data_list">';
              echo '<li class="book_num">在庫：'.$num.'</li>';
              echo '<li class ="book_count">貸出総回数：'.$value[BOOK_COUNTER].'</li>';
              echo '</ul>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</li>';
            }
          }
          echo '</ul>';
          ?>
          <div class="borrow">
            <input class="borrowbutton" type="submit" value="借りる">
          </div>
        </form>
        <div class="page">
          <?php include'./page.php'; ?>
        </div>
        <?php echo '<p align="center">'.$reccnt.'件ヒットしました</p>';?>
      </div>
    </div>
  </div>
  <?php include'footer.php';?>
</body>
</html>