<?php
include './DB.php';
include './api_search.php';
?>
<html>
<head>
 <meta charset="utf-8">
 <link href="../book_css/bookshelf.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
 <link href="../book_css/allpage.css" rel="stylesheet" type="text/css">  <!-- cssの指定 --> 
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
    <h1>確認画面</h1>
  </div>
  <div class="main">
    <FORM METHOD="post" ACTION="confirm.php" NAME="check" onsubmit = "return boxCheck(this)">

      <?php

      if(isset($_POST["book_conf"])){

        for($i = 0; $i < count(@$_POST["book_conf"]); $i++){
          $book_id = @$_POST["book_conf"][$i];
          $user_id = $_SESSION["USERID"];
          $day =  date("Y-m-d H:i:s");
          $re = mysql_query("SELECT * FROM BOOK WHERE BOOK.ID = '$book_id'");
          $value=mysql_fetch_assoc($re);

          if(!empty($value)){
            mysql_query("UPDATE BOOK SET RENT_NUM = RENT_NUM + 1 , BOOK_COUNTER = BOOK_COUNTER + 1 WHERE BOOK.ID = '$book_id'");
            mysql_query("INSERT INTO  KASIDASI (USER_ID,BOOK_ID,BORROW_TIME,STATUS) VALUES ('$user_id','$book_id','$day',1) ");
            $userId = $_SESSION["USERNAME"];
            $comment = $value[BOOK_NAME]." が貸出されました。";
            mysql_query("INSERT INTO  INFO (USER_ID, WRITE_TIME, COMMENT, BOOK_ID,STATUS) VALUES ('$userId','$day','$comment', '$book_id',2) ");
            //mysql_query("UPDATE KASIDASI SET STATUS = 1 WHERE KASIDASI.BOOK_ID = '$book_id'");
          }
        }
        echo'<p sytle="font-size:20px;" align="center">完了しました</p>';
      }else{

        echo "<p style='font-size:20px;' align='center'>あなたが借りる本は以下でよろしいですか？</p>\n";
        echo "<p>";
        echo '<ul class="item_list">';
        for ($i = 0; $i < count(@$_POST["book"]); $i++){

          $book_id = @$_POST["book"][$i];
          $re = mysql_query("SELECT * FROM BOOK WHERE BOOK.ID = '$book_id' ");
          $value=mysql_fetch_assoc($re);
          $items = array();
          $reTest = apiSearch($value[ISBN], $items);
          $imageUrlText = $items[1]['largeImageUrl'];
          $num = $value[BOOK_NUMBER] - $value[RENT_NUM];
          echo '<li class="item">';
          echo '<div class="item_check">';
          echo '<input type="checkbox" name="book_conf[]" checked value="'.$value[ID].'">';
          echo '</div>';
          echo '<div class="item_img">';
          echo '<IMG SRC="'.$imageUrlText.'" style="height:150px;width:130px;">';
          echo '</div>';
          echo '<div class="item_cont">';
          echo '<div class="item_title">';
          echo '<a href="http://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&url=search-alias%3Daps&field-keywords='.$value[BOOK_NAME].'">'.$value[BOOK_NAME].'</a>';
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
        }
        echo '</ul>';
        echo '<div class="complete">';
        echo '<input class="completebutton" type="submit" value="完了">';
        echo '</div>';
      } 

      ?>

    </form>
  </div>

  <?php include'./footer.php';?>
</div>
</body>
</html>