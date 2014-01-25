<?php 
list($first,$mid,$mid2,$last) = split("[/]",$_SERVER['PHP_SELF']);

if($last == "situation.php"){
    if(isset($_GET['word'])){
                        //ページング処理
                        //総レコード数を取得する
                        //条件がある場合は、where 条件式を書く
        $word = htmlspecialchars($_GET["word"]);        /*特殊文字エンコード*/
        $sql = 'SELECT COUNT(*) AS reccnt FROM (KASIDASI LEFT JOIN BOOK  ON KASIDASI.BOOK_ID = BOOK.ID) LEFT JOIN USER ON KASIDASI.USER_ID = USER.ID WHERE KASIDASI.STATUS = 1 AND ((BOOK.BOOK_NAME LIKE ("%'.$word.'%")) OR (BOOK.AUTHOR_NAME LIKE ("%'.$word.'%")) OR (USER.NAME LIKE ("%'.$word.'%")) OR (BOOK.PUBLISHER LIKE ("%'.$word.'%")))';
        $res = mysql_query($sql) or die ("データ抽出エラー");
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $reccnt = $row["reccnt"];
                        //取り出す最大レコード数
                        //$lim = 20 にすれば、1ページにデータを20件表示する
        $lim = 10;

                        //最初と最後のページ番号を定義
        $first = 1;
        $last = ceil($reccnt / $lim);

                        //表示するページ位置を取得
        $p = intval($_GET['p']);
        if ($p < $first) {
            $p = $first;
        }
        elseif ($p > $last) {
            $p = $last;
        }
                        //表示するレコード位置を取得
        $st = ($p - 1) * $lim;

//前後のページ移動数と表示数
//$page = 10 にすれば、現在のページの前後10ページへのリンク番号を表示
//$page = 10 にすれば、現在のページの前後10ページ目に移動できる
        $page = 3;

//前後$pageページ移動した際のページ番号を取得
        $prev = $p - $page;
        $next = $p + $page;

//前後1ページ移動した際のページ番号を取得
        $prev1 = $p - 1;
        $next1 = $p + 1;
        $re = mysql_query('SELECT * FROM (KASIDASI LEFT JOIN BOOK  ON KASIDASI.BOOK_ID = BOOK.ID) LEFT JOIN USER ON KASIDASI.USER_ID = USER.ID WHERE KASIDASI.STATUS = 1 AND ((BOOK.BOOK_NAME LIKE ("%'.$word.'%")) OR (BOOK.AUTHOR_NAME LIKE ("%'.$word.'%")) OR (USER.NAME LIKE ("%'.$word.'%")) OR (BOOK.PUBLISHER LIKE ("%'.$word.'%")))'.$_GET["sort"].' LIMIT '.$st.','.$lim);
    }else{
                        //ページング処理
                        //総レコード数を取得する
                        //条件がある場合は、where 条件式を書く
        $sql = 'SELECT COUNT(*) AS reccnt FROM KASIDASI LEFT JOIN BOOK  ON KASIDASI.BOOK_ID = BOOK.ID LEFT JOIN USER ON KASIDASI.USER_ID = USER.ID WHERE KASIDASI.STATUS = 1';
        $res = mysql_query($sql) or die ("データ抽出エラー");
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $reccnt = $row["reccnt"];
                        //取り出す最大レコード数
                        //$lim = 20 にすれば、1ページにデータを20件表示する
        $lim = 10;

                        //最初と最後のページ番号を定義
        $first = 1;
        $last = ceil($reccnt / $lim);

                        //表示するページ位置を取得
        $p = intval($_GET['p']);
        if ($p < $first) {
            $p = $first;
        }
        elseif ($p > $last) {
            $p = $last;
        }
                        //表示するレコード位置を取得
        $st = ($p - 1) * $lim;

//前後のページ移動数と表示数
//$page = 10 にすれば、現在のページの前後10ページへのリンク番号を表示
//$page = 10 にすれば、現在のページの前後10ページ目に移動できる
        $page = 3;

//前後$pageページ移動した際のページ番号を取得
        $prev = $p - $page;
        $next = $p + $page;

//前後1ページ移動した際のページ番号を取得
        $prev1 = $p - 1;
        $next1 = $p + 1;
        $re = mysql_query('SELECT * FROM KASIDASI LEFT JOIN BOOK  ON KASIDASI.BOOK_ID = BOOK.ID LEFT JOIN USER ON KASIDASI.USER_ID = USER.ID WHERE KASIDASI.STATUS = 1'.$_GET["sort"].' LIMIT '.$st.$lim);
    }
}elseif($last == "bookshelf.php"){
    if(isset($_GET['word'])){
        $word = htmlspecialchars($_GET["word"]);    /*特殊文字エンコード*/
                          //ページング処理
                        //総レコード数を取得する
                        //条件がある場合は、where 条件式を書く
        $sql = 'SELECT COUNT(*) AS reccnt FROM BOOK WHERE (BOOK.BOOK_NAME LIKE ("%'.$word.'%")) OR (BOOK.AUTHOR_NAME LIKE ("%'.$word.'%")) OR (BOOK.PUBLISHER LIKE ("%'.$word.'%")) OR (BOOK.AUTHOR_NAME LIKE ("%'.$word.'%") )';
        $res = mysql_query($sql) or die ("データ抽出エラー");
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $reccnt = $row["reccnt"];
                        //取り出す最大レコード数
                        //$lim = 20 にすれば、1ページにデータを20件表示する
        $lim = 10;

                        //最初と最後のページ番号を定義
        $first = 1;
        $last = ceil($reccnt / $lim);

                        //表示するページ位置を取得
        $p = intval($_GET['p']);
        if ($p < $first) {
            $p = $first;
        }
        elseif ($p > $last) {
            $p = $last;
        }
                        //表示するレコード位置を取得
        $st = ($p - 1) * $lim;

//前後のページ移動数と表示数
//$page = 10 にすれば、現在のページの前後10ページへのリンク番号を表示
//$page = 10 にすれば、現在のページの前後10ページ目に移動できる
        $page = 3;

//前後$pageページ移動した際のページ番号を取得
        $prev = $p - $page;
        $next = $p + $page;

//前後1ページ移動した際のページ番号を取得
        $prev1 = $p - 1;
        $next1 = $p + 1;
        $re = mysql_query('SELECT * FROM BOOK WHERE (BOOK.BOOK_NAME LIKE ("%'.$word.'%")) OR (BOOK.AUTHOR_NAME LIKE ("%'.$word.'%")) OR (BOOK.PUBLISHER LIKE ("%'.$word.'%")) OR (BOOK.AUTHOR_NAME LIKE ("%'.$word.'%") )'.$_GET["sort"].' LIMIT '.$st.','.$lim);

    }else{
                        //ページング処理
                        //総レコード数を取得する
                        //条件がある場合は、where 条件式を書く
        $sql = 'SELECT COUNT(*) AS reccnt FROM BOOK ';
        $res = mysql_query($sql) or die ("データ抽出エラー");
        $row = mysql_fetch_array($res, MYSQL_ASSOC);
        $reccnt = $row["reccnt"];
                        //取り出す最大レコード数
                        //$lim = 20 にすれば、1ページにデータを20件表示する
        $lim = 10;

                        //最初と最後のページ番号を定義
        $first = 1;
        $last = ceil($reccnt / $lim);

                        //表示するページ位置を取得
        $p = intval($_GET['p']);
        if ($p < $first) {
            $p = $first;
        }
        elseif ($p > $last) {
            $p = $last;
        }
                        //表示するレコード位置を取得
        $st = ($p - 1) * $lim;

//前後のページ移動数と表示数
//$page = 10 にすれば、現在のページの前後10ページへのリンク番号を表示
//$page = 10 にすれば、現在のページの前後10ページ目に移動できる
        $page = 3;

//前後$pageページ移動した際のページ番号を取得
        $prev = $p - $page;
        $next = $p + $page;

//前後1ページ移動した際のページ番号を取得
        $prev1 = $p - 1;
        $next1 = $p + 1;
        $re = mysql_query('SELECT * FROM BOOK'.$_GET["sort"].' LIMIT '.$st.$lim);

    }
}elseif($last == "borad.php"){

}elseif($last == "mypage.php"){

}
?>