<?php
include 'DB.php';
include 'api_search.php';
	// ログイン状態のチェック
  if(!isset($_SESSION["USERID"])) { //USERIDが空なら
    header("Location:./logout.php");  //ログアウト画面にとぶ
    exit;
  } 
  ?>

  <html>

  <head>
    <meta charset="utf-8">
    <link href="../book_css/menu.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
    <link href="../book_css/allpage.css" rel="stylesheet" type="text/css">

    <title>本の管理サイト</title>
  </head>
  <body>
    <?php include'./siteheader.php'; ?>
    <div class="sitebox">
      <div class = "header">
        <h1>本の貸し出しサイト</h1>
      </div>
      <!--格項目にとぶ-->
      <!-- <div class ="link" id="link"> -->
      <div class="main">
        <div class="left">
          <div class="search">
            <h5 class="search"><span>サイト内検索</span></h5>
            <form class="s" method="get" action="bookshelf.php">
              <input type="text" name="word" style="height:31px;width:130px;">
              <button type="submit" id="searchbutton"><img src="../book_img/search.png"></button>
            </form>
          </div>
          <!-- </div> -->
          <div class="category">
            <h5 class="category"><span>カテゴリ検索</span></h5>
            <ul class="category">
              <li>C言語</li>
              <li>ruby</li>
              <li>c++</li>
              <li>C#</li>
              <li>objective-c</li>
              <li>haskell</li>
              <li>java</li>
              <li>javascript</li>
              <li>html</li>
              <li>php</li>
              <li>mysql</li>
              <li>MAMP</li>
              <li>perl</li>
            </ul>
          </div>
          <div class="rank">
            <h5 class="rank"><span>貸出ランキング</span></h5>
            <ul class="rank">
              <?php
              $rank=1;
              $re = mysql_query('SELECT * FROM BOOK ORDER BY BOOK.BOOK_COUNTER DESC LIMIT 5');
              while($value=mysql_fetch_assoc($re)){
                $items = array();
                $reTest = apiSearch($value[ISBN], $items);
                $imageUrlText = $items[1]['mediumImageUrl'];

                echo'<p>'.$rank.'位'.$value[BOOK_COUNTER].'回</p>';
                echo'<li class="rank_item">';
                echo'<div class="rank_img">';
                echo'<IMG SRC="'.$imageUrlText.'" style="height100px;width:80px;">';
                echo'</div>';
                echo'<div class="rank_cont">';
                echo'<ul class="rank_list">';
                echo'<li><a href="./detail.php?isbn='.$value[ISBN].'">'.$value[BOOK_NAME].'</a></li>';
                echo'</ul>';
                echo'</div>';
                echo'</li>';
                $rank++;
              }
              ?>
            </ul>
          </div>
        </div>
        <div class = "information">
          <!-- ここに更新状況とかを書く？ -->
          <h3>更新履歴</h3>

          <?php
          $re = mysql_query('SELECT * FROM INFO LEFT JOIN BOOK ON INFO.BOOK_ID = BOOK.ID ORDER BY INFO.WRITE_TIME DESC LIMIT 10');
          echo'<ul class="info">';
          while($value = mysql_fetch_assoc($re)){
            $items = array();
            $reTest = apiSearch($value[ISBN], $items);
            $imageUrlText = $items[1]['largeImageUrl'];
            list($day,$time) = split('[ ]',$value[WRITE_TIME]);
            echo'<li class="info_item">';
            echo'<div class="info_img">';
            echo'<IMG SRC="'.$imageUrlText.'" style="height:160px;width:120px;">';
            echo'</div>';
            echo'<div class="info_cont">';
            echo'<div class="info_time">';
            echo'<div class="time">'.$day.'</div>';
            echo'<div class="user">'.$value[USER_ID].'</div>';
            echo'</div>';   
            echo'<div class="info_comment">';
            //echo $value[COMMENT];
            list($title,$end)=split('[ ]',$value[COMMENT]);
            echo '<a href="./detail.php?isbn='.$value[ISBN].'">'.$title.'</a>'.$end;
            echo'</div>';
            echo'<div class="type">';
            if($value[STATUS]==1){
              echo'<IMG SRC="../book_img/return.png" style="height:50px;width:50px;">';
            }elseif($value[STATUS]==2){
              echo'<IMG SRC="../book_img/rent.png" style="height:50px;width:50px;">';

            }elseif($value[STATUS]==3){
              echo'<IMG SRC="../book_img/add.jpg" style="height:50px;width:50px;">';

            }elseif($value[STATUS]==4){
              echo'<IMG SRC="../book_img/request.png" style="height:50px;width:50px;">';

            }
            echo'</div>';     
            echo'</div>';
            echo'</li>';
          }
          echo'</ul>';
          ?>

        </div>
      </div>
      <?php include'./footer.php';?>
    </div>
  </body>
  </html>