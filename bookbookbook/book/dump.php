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
-- テーブルのデータのダンプ BOOK
--

INSERT INTO BOOK (ID, BOOK_NAME, LINK, PUBLISHER, AUTHOR_NAME, BOOK_COUNTER, BOOK_NUMBER, RENT_NUM, ISBN) VALUES
(1, '午後の紅茶', NULL, '伊藤園', 'ストレート', 23, 3, 3, NULL),
(2, 'シーシーレモン', NULL, 'サントリー', 'レモン', 16, 2, 0, NULL),
(3, '牛乳', NULL, '十字路', '香取', 19, 1, 1, NULL),
(4, 'AR入門', 'http:--www.amazon.co.jp-dp-4777515613', '工学社', '佐野 彰', 8, 1, 1, 1111);

-- --------------------------------------------------------

--
-- テーブルの構造 CATEGORY
--

CREATE TABLE CATEGORY (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'カテゴリid',
  BOOK_ID int(11) NOT NULL COMMENT 'book_id',
  PRIMARY KEY (ID),
  UNIQUE KEY ID (ID),
  KEY BOOK_ID (BOOK_ID)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='カテゴリ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 KASIDASI
--

CREATE TABLE KASIDASI (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  USER_ID int(11) NOT NULL COMMENT 'user_id : ユーザーid',
  BOOK_ID int(11) NOT NULL COMMENT 'book_id',
  BORROW_TIME date NOT NULL COMMENT 'borrow_time',
  RETURN_TIME date NOT NULL COMMENT 'return_time',
  STATUS int(11) DEFAULT '0' COMMENT 'ユーザーの貸し出し履歴',
  PRIMARY KEY (ID),
  UNIQUE KEY ID (ID),
  KEY USER_ID (USER_ID),
  KEY BOOK_ID (BOOK_ID)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='貸し出し' AUTO_INCREMENT=63 ;

--
-- テーブルのデータのダンプ KASIDASI
--
INSERT INTO KASIDASI (ID, USER_ID, BOOK_ID, BORROW_TIME, RETURN_TIME, STATUS) VALUES
(8, 1, 1, '2013-11-19', '2013-12-05', 0),
(9, 1, 2, '2013-11-19', '2013-12-06', 0),
(10, 1, 3, '2013-11-19', '2013-12-06', 0),
(11, 1, 3, '2013-11-19', '2013-12-06', 0),
(12, 1, 3, '2013-11-19', '2013-12-06', 0),
(13, 1, 3, '2013-11-19', '2013-12-06', 0),
(14, 1, 3, '2013-11-19', '2013-12-06', 0),
(15, 1, 1, '2013-11-19', '2013-12-05', 0),
(16, 1, 2, '2013-11-20', '2013-12-06', 0),
(17, 1, 3, '2013-11-20', '2013-12-06', 0),
(18, 1, 1, '2013-11-22', '2013-12-05', 0),
(19, 1, 3, '2013-11-22', '2013-12-06', 0),
(20, 1, 1, '2013-11-26', '2013-12-05', 0),
(21, 1, 2, '2013-11-26', '2013-12-06', 0),
(22, 1, 3, '2013-11-26', '2013-12-06', 0),
(23, 1, 1, '2013-11-29', '2013-12-05', 0),
(24, 1, 2, '2013-11-29', '2013-12-06', 0),
(25, 1, 3, '2013-11-29', '2013-12-06', 0),
(26, 1, 1, '2013-11-29', '2013-12-05', 0),
(27, 1, 3, '2013-11-29', '2013-12-06', 0),
(28, 1, 1, '2013-11-29', '2013-12-05', 0),
(29, 1, 2, '2013-11-29', '2013-12-06', 0),
(30, 1, 3, '2013-11-29', '2013-12-06', 0),
(31, 1, 1, '2013-11-29', '2013-12-05', 0),
(32, 1, 2, '2013-11-29', '2013-12-06', 0),
(33, 1, 3, '2013-11-29', '2013-12-06', 0),
(34, 1, 4, '2013-11-29', '2013-12-06', 0),
(35, 1, 4, '2013-11-29', '2013-12-06', 0),
(36, 1, 4, '2013-11-29', '2013-12-06', 0),
(37, 1, 1, '2013-11-29', '2013-12-05', 0),
(38, 1, 2, '2013-11-29', '2013-12-06', 0),
(39, 1, 3, '2013-11-29', '2013-12-06', 0),
(40, 1, 4, '2013-11-29', '2013-12-06', 0),
(41, 1, 1, '2013-12-03', '2013-12-05', 0),
(42, 1, 2, '2013-12-03', '2013-12-06', 0),
(43, 1, 1, '2013-12-03', '2013-12-05', 0),
(44, 1, 2, '2013-12-03', '2013-12-06', 0),
(45, 1, 3, '2013-12-03', '2013-12-06', 0),
(46, 1, 4, '2013-12-03', '2013-12-06', 0),
(47, 1, 1, '2013-12-03', '2013-12-05', 0),
(48, 1, 4, '2013-12-03', '2013-12-06', 0),
(49, 1, 2, '2013-12-03', '2013-12-06', 0),
(50, 1, 4, '2013-12-03', '2013-12-06', 0),
(51, 1, 2, '2013-12-03', '2013-12-06', 0),
(52, 2, 1, '2013-12-03', '2013-12-05', 0),
(53, 1, 1, '2013-12-03', '2013-12-05', 0),
(54, 1, 1, '2013-12-04', '2013-12-05', 0),
(55, 1, 2, '2013-12-04', '2013-12-06', 0),
(56, 1, 3, '2013-12-04', '2013-12-06', 0),
(57, 1, 1, '2013-12-04', '2013-12-05', 0),
(58, 2, 1, '2013-12-04', '2013-12-05', 0),
(59, 2, 1, '2013-12-05', '2013-12-05', 0),
(60, 1, 1, '2013-12-06', '0000-00-00', 1),
(61, 1, 3, '2013-12-06', '0000-00-00', 1),
(62, 1, 4, '2013-12-06', '2013-12-06', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 USER
--

CREATE TABLE USER (
  ID int(11) NOT NULL AUTO_INCREMENT COMMENT 'id : ユーザーid',
  NAME varchar(128) CHARACTER SET utf8 NOT NULL COMMENT 'ユーザー名',
  PASS varchar(256) NOT NULL COMMENT 'pass',
  CREATED date NOT NULL COMMENT '登録された日',
  PRIMARY KEY (ID),
  UNIQUE KEY ID (ID)
  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='ユーザー情報' AUTO_INCREMENT=3 ;

--
-- テーブルのデータのダンプ USER
--

INSERT INTO USER (ID, NAME, PASS, CREATED) VALUES
(1, 'abcdefujiii@gmail.com', 'tanitani', '20131119'),
(2, 'ken', 'aa', '20131203');

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 CATEGORY
--
ALTER TABLE CATEGORY
ADD CONSTRAINT CATEGORY_ibfk_1 FOREIGN KEY (BOOK_ID) REFERENCES BOOK (ID);

--
-- テーブルの制約 KASIDASI
--
ALTER TABLE KASIDASI
ADD CONSTRAINT KASIDASI_ibfk_1 FOREIGN KEY (USER_ID) REFERENCES USER (ID),
ADD CONSTRAINT KASIDASI_ibfk_2 FOREIGN KEY (BOOK_ID) REFERENCES BOOK (ID);
);"
);
 ?>