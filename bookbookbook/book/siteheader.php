<div class="siteheader">
  <div class="headerbox">
    <div class="menu">
      <ul class="menu">
        <li style="border-left-width: 0px;" class="menu"><a href="./menu.php">TOP</a></li>
        <li class="menu"><a href="./situation.php">貸出状況</a></li>
        <li class="menu"><a href="./bookshelf.php">本棚</a></li>
        <li class="menu"><a href="./add_book.php">本の追加</a></li>
        <li class="menu"><a href="./wanted.php">本のリクエスト</a></li>
        <li class="menu"><a href="./device.php">デバイス</a></li>
      </ul>
    </div>
    <div class="account">
      <ul class="account">
        <li style="border-left-width: 0px;" class="acc"><?php echo $_SESSION["USERNAME"].'さん'; ?></li>
        <li class="menu"><a href="./mypage.php">マイページ</a></li>
        <li class="menu"><a href="./logout.php">ログアウト</a></li>
      </ul>
    </div>
  </div>
</div>