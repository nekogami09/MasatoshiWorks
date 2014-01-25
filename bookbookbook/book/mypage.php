<?php
include'DB.php';
include'api_search.php';
?>

<html>
<head>
	<meta charset="utf-8">  <!-- 文字コードの設定 -->
	<link href="../book_css/mypage.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
	<link href="../book_css/allpage.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->

	<title>本の貸し出し管理サイト</title>
	<script type="text/javascript" src="../book_js/jquery-1.2.6.js"></script>

	<!-- ui tabs.js -->
	<script type="text/javascript" src="../book_js/ui.core.js"></script>
	<script type="text/javascript" src="../book_js/ui.tabs.js"></script>


	<!-- タブのデフォルト -->
	<script type="text/javascript">
	$(function() {
		$('#ui-tab > ul').tabs();
	});
	</script>

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
	<?php include'siteheader.php';?>
	<div class="sitebox">
		<div class = "header">
			<h1>マイページ</h1>
		</div>
		<div class="main">
			<div id="ui-tab">
				<ul>
					<li><a href="#fragment-1"><span>現在の貸出状況</span></a></li>
					<li><a href="#fragment-2"><span>過去の貸出状況</span></a></li>
				</ul>

				<div id="fragment-1">
					<div class="bigbox">
						<?php include'leftbar.php';?>
						<div class="list">
							<?php
							$user_id = $_SESSION["USERID"];
							if(isset($_POST["rent"])){
								for($i = 0; $i < count(@$_POST["rent"]); $i++){
									$book_id = @$_POST["rent"][$i];
									$day =  date("Y-m-d H:i:s");
									$user_id = $_SESSION["USERID"];
									$re = mysql_query("SELECT * FROM KASIDASI LEFT JOIN BOOK ON KASIDASI.BOOK_ID = BOOK.ID WHERE KASIDASI.USER_ID = '$user_id'");
									$value=mysql_fetch_assoc($re);
			//$book_id = $value["BOOK_ID"];
									if(!empty($value)){
										$user_id = $_SESSION["USERNAME"];
										$comment = $value[BOOK_NAME]." が返却されました。";	
										mysql_query("UPDATE BOOK SET RENT_NUM = RENT_NUM -1  WHERE BOOK.ID = '$book_id' ");
										mysql_query("UPDATE KASIDASI SET RETURN_TIME = '$day', STATUS = 0 WHERE KASIDASI.BOOK_ID ='$book_id' ");
										mysql_query("INSERT INTO  INFO (USER_ID, WRITE_TIME, COMMENT, BOOK_ID,STATUS) VALUES ('$user_id','$day','$comment', '$book_id',1) ");
									}
								}
								echo'<p align="center">完了しました</p>';
								echo'<br>';

							}
							else{
								echo'<FORM METHOD="post" ACTION="mypage.php" NAME="check" onsubmit = "return boxCheck(this)" >';
								$re = mysql_query("SELECT * FROM KASIDASI LEFT JOIN BOOK  ON KASIDASI.BOOK_ID = BOOK.ID WHERE KASIDASI.USER_ID = '$user_id' AND KASIDASI.STATUS = 1 ".$_GET["sort"]);
								echo '<ul class="item_list">';
								while($value=mysql_fetch_assoc($re)){
									$items = array();
									$reTest = apiSearch($value[ISBN], $items);
									$imageUrlText = $items[1]['largeImageUrl'];
									$num = $value[BOOK_NUMBER] - $value[RENT_NUM];
									echo '<li class="item_x">';
									echo '<div class="item_check">';
									echo '<input type="checkbox" name="rent[]" value="'.$value[ID].'">';
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
									echo '<div class="item_news">';
									echo '<ul class="news_list">';
									echo '<li class="user_name">ユーザー：'.$_SESSION["USERNAME"].'</li>';
									echo '<li class ="borrow_time">貸出日：'.$value[BORROW_TIME].'</li>';
									echo '</ul>';
									echo '</div>';
									echo '</div>';
									echo '</li>';
								}
								echo '</ul>';
								echo '<div class="return">';
								echo '<input class="returnbutton" type="submit" value="返却">';
								echo '</div>';
							}

							?>
						</div>
					</div>
				</div>

				<div id="fragment-2">
					<div class="bigbox">
						<?php include'leftbar.php';?>
						<div class="list">
							<?php
							$count=0;
							$user_id=$_SESSION["USERID"];
							$re =mysql_query("SELECT * FROM KASIDASI LEFT JOIN BOOK  ON KASIDASI.BOOK_ID = BOOK.ID WHERE '$user_id' = KASIDASI.USER_ID AND KASIDASI.STATUS = 0".$_GET["sort"]);
							echo '<ul class="item_list">';
							while($value=mysql_fetch_assoc($re) and $count <10){
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
								echo '<li class ="user_name">貸出日：'.$value[BORROW_TIME].'</li>';
								echo '<li class ="return_time">返却日：'.$value[RETURN_TIME].'</li>';
								echo '</ul>';
								echo '</div>';
								echo '</div>';
								echo '</li>';
								$count++;
							}
							echo '</ul>';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include'footer.php';?>
	</div>
</body>
</html>