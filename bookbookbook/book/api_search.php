<?php
$RakutenBooksItems = array(
		'title',			//書籍タイトル
		'titleKana',		//書籍タイトル カナ
		'subTitle',			//書籍サブタイトル
		'subTitleKana',		//書籍サブタイトル カナ
		'seriesName',		//叢書名
		'seriesNameKana',	//叢書名カナ
		'contents',			//多巻物収録内容
		'contentsKana',		//多巻物収録内容カナ
		'author',			//著者名
		'authorKana',		//著者名カナ
		'publisherName',	//出版社名
		'size',				//書籍のサイズ
		'isbn',				//ISBNコード(書籍コード)
		'itemCaption',		//商品説明文
		'salesDate',		//発売日
		'itemPrice',		//税込み販売価格
		'listPrice',		//定価
		'discountRate',		//割引率
		'discountPrice',	//割引価格
		'itemUrl',			//商品URL
		'affiliateUrl',		//アフィリエイトURL
		'smallImageUrl',	//商品画像 64x64URL
		'mediumImageUrl',	//商品画像 128x128URL
		'largeImageUrl',	//商品画像 200x200URL
		'chirayomiUrl',		//チラよみURL
		'availability',		//在庫状況
		'postageFlag',		//送料フラグ
		'limitedFlag',		//限定フラグ
		'reviewCount',		//レビュー件数
		'reviewAverage',	//レビュー平均
		'booksGenreId'		//楽天ブックスジャンルID
	);

/**
 * PHP5かどうか検査する
 * return	bool TRUE:PHP5である／FALSE:それ以外のバージョン
*/
function isphp5() {
	return preg_match('/^5/', phpversion()) == 0 ? FALSE : TRUE;
}

//
function apiSearch($isbnC, &$items){

	//逸見のID
	$developerId = "1024042916974184640";		//デベロッパID
	$affiliateId = "121e2fe4.633526f2.121e2fe5.25f3d260";	//アフィリエイトID

	//楽天ブックスAPIのURLを取得する
	$url = "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522?applicationId={$developerId}&affiliateId={$affiliateId}&format=xml&isbn={$isbnC}";

	//楽天ブックスAPIから書籍情報を取り出す（XML形式）
	$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //サーバ証明書検証をスキップ
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //　　〃
		$res = curl_exec($ch);
		curl_close($ch);

		//楽天ブックスに入れなかった
		if(!$res) return 0;

	/**
	 * 楽天ブックスAPIから必要な情報を配列に格納する
	 * param	string $query ISBN番号または書名
	 * param	string $author 著者名
	 * param	array $items 情報を格納する配列
	 * return	ヒットした件数／FALSE：検索に失敗
	*/
		global $RakutenBooksItems;

	//PHP4用; DOM XML利用
	if (isphp5() == FALSE) {
		if (($dom = domxml_open_mem($res)) == NULL)	return FALSE;
		$root = $dom->get_elements_by_tagname('root');

		//レスポンス・チェック
		$count = $root[0]->get_elements_by_tagname('count');
		$cnt = $count[0]->get_content();
		if ($cnt <= 0)		return FALSE;		//ヒットせず
		//書籍情報取りだし
		$obj = $root[0]->get_elements_by_tagname('Items');
		$obj = $obj[0]->get_elements_by_tagname('Item');
		$cnt = 1;
		foreach ($obj as $val) {
			foreach ($RakutenBooksItems as $name) {
				$node = $val->get_elements_by_tagname($name);
				if ($node != NULL) {
					$items[$cnt][$name] = $node[0]->get_content();
				}
			}
			// $items[$cnt]['title'] = preg_replace("/([あ-ん|ア-ン])-/ui", "$1ー", $items[$cnt]['title']);
			// $items[$cnt]['titleKana'] = preg_replace("/([あ-ん|ア-ン])-/ui", "$1ー", $items[$cnt]['titleKana']);
			$cnt++;
		}

//PHP5用; SimpleXML利用
	} else {
		$xml = simplexml_load_string($res);
		//レスポンス・チェック
		$count = (int)$xml->count;
		if ($count <= 0)	return FALSE;
		$obj = $xml->Items->Item;
		$cnt = 1;
		foreach ($obj as $node) {
			foreach ($RakutenBooksItems as $name) {
				if (isset($node->$name)) {
					$items[$cnt][$name] = (string)$node->$name;
				}
			}
			// $items[$cnt]['asin'] = isbn2asin($items[$cnt]['isbn']);
			// $items[$cnt]['title'] = preg_replace("/([あ-ん|ア-ン])-/ui", "$1ー", $items[$cnt]['title']);
			// $items[$cnt]['titleKana'] = preg_replace("/([あ-ん|ア-ン])-/ui", "$1ー", $items[$cnt]['titleKana']);
			$cnt++;
		}
	}
	return $cnt - 1;
}

?>