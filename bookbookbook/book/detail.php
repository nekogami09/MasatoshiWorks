<?php
include './DB.php';
include'./api_search.php';
?>
<html>
<head>
 <meta charset="utf-8">
 <link href="../book_css/detail.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
 <link href="../book_css/allpage.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php include'./siteheader.php';?>
  <div class="sitebox">
    <div class = "header">
     <h1>詳細</h1>
   </div>
   <div class="main">
    <?php
    $re=mysql_query("SELECT * FROM BOOK WHERE BOOK.ISBN = ".$_GET["isbn"]);
    $value=mysql_fetch_assoc($re);
    $items = array();
    $reTest = apiSearch($value[ISBN], $items);
    $imageUrlText = $items[1]['largeImageUrl'];
    $cont = $items[1]['itemCaption'];
    $num = $value[BOOK_NUMBER] - $value[RENT_NUM];
          //div book_area
    echo'<div class=book_area>';
    echo '<div class="item_img">';
    echo '<IMG SRC="'.$imageUrlText.'" style="height:200px;width:170px;">';
    echo '<form method="post" action="./confirm.php">';
    echo '<input type="hidden" name="book" value="'.$value[ID].'">';
    echo '<input type="submit" value="借りる">';
    echo '</form>';
    echo '</div>';
    echo '<div class="item_cont">';
    echo '<div class="item_title">';
    echo '<a href="'.$value[LINK].'">'.$value[BOOK_NAME].'</a>';
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
    echo '<div class="item_ex">';
    echo '内容説明';
    echo '<p>'.$cont.'</p>';
    echo '</div>';
    echo '</div>';
    echo'</div>';
          //div category_area
    echo'<div class="category_area">';
    echo '同じカテゴリの人気本';
    echo $review;
    echo'</div>';
    ?>
  </div>
  <?php include'footer.php';?>
</div>

</body>
</html>