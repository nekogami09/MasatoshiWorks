<!--ログアウト画面-->
<?php
include './DB.php';
?>

<!doctype html>

<HTML>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- ソースコード表示の指定 -->
    <link href="../book_css/board.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
    <link href="../book_css/allpage.css" rel="stylesheet" type="text/css">  <!-- cssの指定 -->
    <script type="text/javascript" src="../book_js/board_js/shCore.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushBash.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushCpp.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushCSharp.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushCss.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushDelphi.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushDiff.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushGroovy.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushJava.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushJScript.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushPhp.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushPlain.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushPython.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushRuby.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushSql.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushVb.js"></script>
    <script type="text/javascript" src="../book_js/board_js/shBrushXml.js"></script>
    <link type="text/css" rel="stylesheet" href="../book_js/board_js/shCore.css"/>
    <link type="text/css" rel="stylesheet" href="../book_js/board_js/shThemeDefault.css"/>
    <script type="text/javascript">
    SyntaxHighlighter.config.clipboardSwf = '../book_js/board_js/clipboard.swf';
    SyntaxHighlighter.all();
    </script>
    <script type="text/javascript">
    function toggle (targetId) {
      if ( document.getElementById ) {
        target = document.getElementById ( targetId );
        if ( target.style.display == "none" ) {
          target.style.display = "block";
        }else{
          target.style.display = "none";
        }
      }
    }
    </script>


  </head>
  <BODY>
    <?php include'siteheader.php';?>
    <div class="sitebox">
      <div class="header">
        <h1>掲示板</h1>
      </div>
      <div class="main">
        <?php

//----------------必要なデーターを集めデータを登録します-------------------

        if(isset($_POST["DEL"])){
          $sql = "DELETE FROM BOARD WHERE ID = $_POST[DEL]";
          mysql_query( $sql );
        }
//echo $comment."<br>";
//echo $name."<br>";
//echo $sb_id."<br>";
if(isset($_POST["COMMENT"])){ //新規データが空でない（つまり有る）ならば
  $comment = $_POST["COMMENT"];
  $name = $_SESSION["USERNAME"];
  $date=date("y-m-d H:i:s");
  $ct = $_POST["ct"];
  $sql = "INSERT INTO BOARD(USER_ID,COMMENT,WRITE_TIME,COMMENT_TYPE)VALUES('$_SESSION[USERNAME]','$comment','$date','$ct')";
  mysql_query( $sql );
    //BOARDにデータを追加しなさい。というSQL文
}


//------------------ＨＴＭLフォーム出力部分---------------------------------

 //入力フォームを書き出します。

echo "<FORM action = 'board.php' method='POST'>";

echo "ソースコード:<br><textarea rows='5' cols='70' wrap='OFF' name='COMMENT'></textarea>";
echo "<SELECT style='display: inline' name='ct'>
<OPTION value='Normal'>text</OPTION>
<OPTION value='cpp'>C++</OPTION>
<OPTION value='c'>C</OPTION>
<OPTION value='c-sharp'>C#</OPTION>
<OPTION value='ruby'>Ruby</OPTION>
<OPTION value='java'>Java</OPTION>
<OPTION value='php'>PHP</OPTION>
</SELECT>";
echo "<INPUT type='submit' value='ソースコード書き込み'>";
echo "</FORM>";

echo "<FORM action = 'board.php' method='POST'>";
    //echo "<input type='hidden' name='sb_id' value = '$sb_id'>";
echo "<INPUT type='submit' value='更新'>";
echo "</FORM>";

//------------------データベースを読みながら、HTMLを出力します-------------。

$sql = "SELECT *FROM BOARD ORDER BY WRITE_TIME DESC ";
$res = mysql_query( $sql );
    //BOARDテーブルから、noを基準に０-３０件のデータを逆順（desc)で得る
$No = 1;
echo "<HR>";
while ( $row = mysql_fetch_assoc($res)){ //最後のデータになるまで繰返し

  echo "<HR>";
  echo $No.":".$row[USER_ID]."さん"."  ".$row[WRITE_TIME]."&nbsp&nbsp&nbsp";
  if($row[USER_ID] == $_SESSION["USERNAME"]){
    echo "[";
    echo "<FORM METHOD='post' style='display: inline' ACTION='board.php' NAME = 'boarddlform'>";
    echo "<input type='hidden' name='DEL' value = '$row[ID]'>";
    echo "<input type='submit' value='削除'>";
    echo "</form>";
    echo "]";
  }
  echo "<br>";
  if($row[COMMENT_TYPE] == 'Normal'){
    echo "&nbsp&nbsp&nbsp";
    echo $row[COMMENT];
  }else{
    //echo "<a href='' onclick='toggle(source);return false;''>▼ソースコード</a>
    //<div id=source style='display: none;''>";
    echo "<pre class='brush: $row[COMMENT_TYPE]'>";
    echo $row[COMMENT];
    echo "</pre>";
    //echo "</div>";
  }
  $No += 1;
}
echo "<HR>";
echo "<HR>";

?>

</div>
<?php include'footer.php';?>
</div>


</BODY>
</HTML>
