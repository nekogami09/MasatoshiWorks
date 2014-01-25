 <?php
 include './DB.php';


 mysql_query(
  "CREATE TABLE BOOK (
    ID int(11) NOT NULL AUTO_INCREMENT,
    BOOK_NAME varchar(256) CHARACTER SET utf8 NOT NULL,
    LINK varchar(256) CHARACTER SET utf8 DEFAULT NULL,
    PUBLISHER varchar(256) CHARACTER SET utf8 NOT NULL,
    AUTHOR_NAME varchar(256) CHARACTER SET utf8 NOT NULL,
    BOOK_COUNTER int(11) DEFAULT '0',
    BOOK_NUMBER int(11) NOT NULL,
    RENT_NUM int(11) DEFAULT '0',
    ISBN int(11) DEFAULT NULL,
    PRIMARY KEY (ID)
    );
--
-- テーブルのデータのダンプ `BOOK`
--

INSERT INTO BOOK (ID, BOOK_NAME, LINK, PUBLISHER, AUTHOR_NAME, BOOK_COUNTER, BOOK_NUMBER, RENT_NUM, ISBN) VALUES
(1, 'AR入門', 'http://www.amazon.co.jp/dp/4777515613', '工学社', '佐野 彰', 2, 2, 1, '1111'),
(2, 'ThinkStats-プログラマのための統計入門', 'http://books.google.co.jp/books?id=PHiwMQEACAAJ&dq=9784873115726&hl=ja&sa=X&ei=myaoUpTjK4bPlAWJr4CYAw&redir_esc=y', 'オライリー・ジャパン', 'Allen B. Downey', 2, 2, 1, '9784873115726'),
(3, 'jQuery＋CSSフレームワークでサクサクつくる「動き」と「仕掛け」 実践Webデザイン', 'http://store.shopping.yahoo.co.jp/guruguru/9784844363576.html', 'エムディエヌコーポレーション', '共著 アルディート', 0, 1, 0, '9784844363576'),
(4, '「タッチパネル」のゲームデザイン――アプリやゲームをおもしろくするテクニック', 'http://www.oreilly.co.jp/books/9784873116204/', 'オライリー・ジャパン', 'Scott Rogers', 0, 1, 0, '9784873116204');

-- --------------------------------------------------------

--
-- テーブルの構造 `BORAD`
--

CREATE TABLE BORAD (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  USER_ID varchar(256) DEFAULT NULL COMMENT 'user_id',
  COMMENT varchar(256) NOT NULL COMMENT 'comment',
  PRIMARY KEY (ID)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='掲示板' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `CATEGORY`
--

CREATE TABLE CATEGORY (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'カテゴリid',
  BOOK_ID int(11) NOT NULL COMMENT 'book_id',
  PRIMARY KEY (ID),
  KEY BOOK_ID (BOOK_ID)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='カテゴリ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `INFO`
--

CREATE TABLE INFO (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  USER_ID varchar(256) DEFAULT NULL COMMENT 'user_id',
  WRITE_TIME datetime NOT NULL COMMENT '時間',
  COMMENT varchar(256) DEFAULT NULL COMMENT 'comment',
  BOOK_ID int(11) NOT NULL COMMENT 'book_id',
  STATUS int(11) DEFAULT NULL COMMENT 'status',
  PRIMARY KEY (ID),
  KEY BOOK_ID (BOOK_ID)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='更新状況' AUTO_INCREMENT=12 ;

--
-- テーブルのデータのダンプ `INFO`
--

INSERT INTO INFO (ID, USER_ID, WRITE_TIME, COMMENT, BOOK_ID, STATUS) VALUES
(1, 'abcdefujiii@gmail.com', '2013-12-11 10:03:07', 'AR入門 が追加されました。', 1, 3),
(2, 'abcdefujiii@gmail.com', '2013-12-11 10:03:28', 'ThinkStats-プログラマのための統計入門 が追加されました。', 2, 3),
(3, 'abcdefujiii@gmail.com', '2013-12-11 10:07:03', 'jQuery＋CSSフレームワークでサクサクつくる「動き」と「仕掛け」 実践Webデザイン が追加されました。', 3, 3),
(4, 'abcdefujiii@gmail.com', '2013-12-11 10:09:11', '「タッチパネル」のゲームデザイン――アプリやゲームをおもしろくするテクニック が追加されました。', 4, 3),
(5, 'abcdefujiii@gmail.com', '2013-12-11 11:13:22', 'AR入門 が貸出されました。', 1, 2),
(6, 'abcdefujiii@gmail.com', '2013-12-11 11:13:22', 'ThinkStats-プログラマのための統計入門 が貸出されました。', 2, 2),
(7, 'abcdefujiii@gmail.com', '2013-12-11 11:42:59', 'AR入門 が追加されました。', 1, 3),
(8, 'abcdefujiii@gmail.com', '2013-12-11 12:18:06', 'AR入門 が返却されました。', 1, 1),
(9, 'abcdefujiii@gmail.com', '2013-12-11 12:18:06', 'AR入門 が返却されました。', 2, 1),
(10, 'abcdefujiii@gmail.com', '2013-12-11 12:21:28', 'AR入門 が貸出されました。', 1, 2),
(11, 'abcdefujiii@gmail.com', '2013-12-11 12:21:28', 'ThinkStats-プログラマのための統計入門 が貸出されました。', 2, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `KASIDASI`
--

CREATE TABLE KASIDASI (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  USER_ID int(11) NOT NULL COMMENT 'user_id : ユーザーid',
  BOOK_ID int(11) NOT NULL COMMENT 'book_id',
  BORROW_TIME date NOT NULL COMMENT 'borrow_time',
  STATUS int(11) DEFAULT '0' COMMENT 'ユーザーの貸し出し履歴',
  RETURN_TIME date NOT NULL COMMENT 'return_time',
  PRIMARY KEY (ID),
  UNIQUE KEY ID (ID),
  KEY USER_ID (USER_ID),
  KEY BOOK_ID (BOOK_ID)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='貸し出し' AUTO_INCREMENT=5 ;

--
-- テーブルのデータのダンプ `KASIDASI`
--

INSERT INTO KASIDASI (ID, USER_ID, BOOK_ID, BORROW_TIME, STATUS, RETURN_TIME) VALUES
(1, 1, 1, '2013-12-11', 0, '2013-12-11'),
(2, 1, 2, '2013-12-11', 0, '2013-12-11'),
(3, 1, 1, '2013-12-11', 1, '0000-00-00'),
(4, 1, 2, '2013-12-11', 1, '0000-00-00');

-- --------------------------------------------------------

--
-- テーブルの構造 `REQUEST`
--

CREATE TABLE REQUEST (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  USER_ID varchar(256) DEFAULT NULL COMMENT 'user_id',
  REQUEST_TIME datetime NOT NULL COMMENT 'request_time',
  ADD_TIME datetime NOT NULL COMMENT 'add_time',
  BOOK_ID int(11) NOT NULL COMMENT 'book_id',
  STATUS int(11) DEFAULT NULL COMMENT 'STATUS',
  PRIMARY KEY (ID),
  KEY BOOK_ID (BOOK_ID)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='リクエスト' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `USER`
--

CREATE TABLE USER (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id : ユーザーid',
  NAME varchar(128) NOT NULL COMMENT 'ユーザー名',
  PASS varchar(256) NOT NULL COMMENT 'pass',
  CREATED date NOT NULL COMMENT '登録された日',
  PRIMARY KEY (ID),
  UNIQUE KEY ID (ID)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ユーザー情報' AUTO_INCREMENT=2 ;

--
-- テーブルのデータのダンプ `USER`
--

INSERT INTO USER (ID, NAME, PASS, CREATED) VALUES
(1, 'abcdefujiii@gmail.com', 'tanitani', '2013-12-11');

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `CATEGORY`
--
ALTER TABLE CATEGORY
ADD CONSTRAINT CATEGORY_ibfk_1 FOREIGN KEY (BOOK_ID) REFERENCES BOOK (ID);

--
-- テーブルの制約 `INFO`
--
ALTER TABLE INFO
ADD CONSTRAINT INFO_ibfk_1 FOREIGN KEY (BOOK_ID) REFERENCES BOOK (ID);

--
-- テーブルの制約 `KASIDASI`
--
ALTER TABLE KASIDASI
ADD CONSTRAINT KASIDASI_ibfk_2 FOREIGN KEY (BOOK_ID) REFERENCES BOOK (ID),
ADD CONSTRAINT KASIDASI_ibfk_1 FOREIGN KEY (USER_ID) REFERENCES USER (ID);

--
-- テーブルの制約 `REQUEST`
--
ALTER TABLE REQUEST
ADD CONSTRAINT REQUEST_ibfk_1 FOREIGN KEY (BOOK_ID) REFERENCES BOOK (ID);
);"
 );
 ?>