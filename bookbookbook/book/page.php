<?php

//ページ移動リンクの組み立て

//1ページ前のページ
if ($p > 1) {
    $back = $_SERVER['PHP_SELF']."?word=".$_GET["word"]."&sort=".$_GET["sort"]."&p=".$prev1;
    echo "<a href='".$back."''> < </a>";
}

//各ページ番号への移動リンクを表示
for ($cnt = $p - $page; $cnt <= $last; $cnt++) {
    if ($cnt < 1) {
        $cnt = 1;
    }
    $no = $_SERVER['PHP_SELF']."?word=".$_GET["word"]."&sort=".$_GET["sort"]."&p=".$cnt;
    $pageno = "<a href='".$no."'> ".$cnt." </a>";

//表示番号を指定数に区切る
//ページ番号と現在のページが同一の場合は
//リンク無しにする 
    if ($cnt <= $p + $page) {
        if ($cnt == $p) {
            $pageno = $p;
        }
        echo $pageno;
    }
}

//1ページ後のページ

if (($next1 - 1) * $lim < $reccnt) {
    $go = $_SERVER['PHP_SELF']."?word=".$_GET["word"]."&sort=".$_GET["sort"]."&p=".$next1;
    echo "<a href='".$go."'>  > </a>";
}

echo "<br>";



//前の$pageページへ移動
if ($p > $page) {
    $pre = $_SERVER['PHP_SELF']."?word=".$_GET["word"]."&sort=".$_GET["sort"]."&p=".$prev;
    echo "<a href='".$pre."'> << </a>";
}

//次の$pageページへ移動
if (($next - 1) * $lim < $reccnt) {
// >> を $page"."ページ進む にする事もできる
    $nex =$_SERVER['PHP_SELF']."?word=".$_GET["word"]."&sort=".$_GET["sort"]."&p=".$next;
    echo "<a href='".$nex."'> >> </a>";
}

?>