<?php
include'DB.php';
include'api_search.php';
?>

<html>

<head>
	<meta charset="utf-8">  <!-- 文字コードの設定 -->
	<link href="../book_css/situation.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
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
	<!-- <h1>貸し出し履歴</h1> -->
	<?php include'siteheader.php';?>
	<div class="sitebox">
		<div class = "header">
			<h1>貸出状況</h1>
		</div>
		<div class="main">
			<div class = "searchForm">  
				<form class="s" method="get" action="situation.php">
					<input type="text" name="word" style = "width: 300px;height:35px;">
					<button type="submit" id="searchbutton"><img src="../book_img/search.png"></button>
				</form>
			</div>
			<div class="bigbox">
				<?php include'leftbar.php';?>
				<div class="list">
					<?php
					$user_id = $_SESSION["USERID"];
					echo'<form method="get" action="mail.php">';
					include'./paging.php';
					echo '<ul class="item_list">';
					while($value=mysql_fetch_assoc($re)){
						$items = array();
						$reTest = apiSearch($value[ISBN], $items);
						$imageUrlText = $items[1]['largeImageUrl'];
						$num = $value[BOOK_NUMBER] - $value[RENT_NUM];
						echo '<li class="item">';
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
						echo '<div class="item_news">';
						echo '<ul class="news_list">';
						echo '<li class="user_name">ユーザー：'.$value[NAME].'<button type="submit" name="send" value="'.$value[NAME].'$'.$value[BOOK_NAME].'">警告</button></li>';
						echo '<li class ="borrow_time">貸出日：'.$value[BORROW_TIME].'</li>';
						echo '</ul>';
						echo '</div>';
						echo '</div>';
						echo '</li>';
					}
					
					echo '</ul>';
					echo '</form>';
					echo '<div class="page">';
					include'./page.php';
					echo'</div>';
					echo '<p align="center">'.$reccnt.'件ヒットしました</p>';
					?>
				</div>
			</div>
		</div>
		<?php include'footer.php';?>
	</div>
</body>
</html>