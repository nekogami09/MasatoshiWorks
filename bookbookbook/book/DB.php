<?php					
	// session_cache_limiter('private_no_expire');				
session_start();				
	// データベースに接続する処理。				
	// 環境に応じて以下の変数を書き換えます。				
	$host = "localhost";	// 接続先ホスト名			
	$user = "root";			// 接続ユーザ名	
	$pass = "root";				// 接続パスワード 本番はpweに変更
	$dbname = "bbb";			// データベース名	
	//MySQLへ接続する				
 	// echo "test"; 
	$link =  mysql_connect( $host, $user, $pass ) or die("MySQL 接続エラー");				
	// print "成功しました！";				
	//データベースを選択する				
	mysql_select_db( $dbname , $link) or die ("DBの選択に失敗");				
	//文字コードを指定する				
	mysql_set_charset('utf8');				
	?>