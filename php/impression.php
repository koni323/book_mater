<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");
if(!isset($_SESSION['User'])){
  header('Location: /phpselfmade_konishi/users/login.php');
    exit;
}
$result['User'] =$_SESSION['User'];
try{
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDb();
  if(isset($_GET['logout'])){
    // セッション破棄
    $_SESSION = array();
    session_destroy();
  }
  // 参照処理
  $book_result['Books']=$user->book_find($_POST['id']);
}
catch (PDOException $e) {
  echo "エラー!: " . $e->getMessage();
}
?>
﻿<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BOOK MATER</title>
<link rel="stylesheet" type="text/css" href="../css/impression.css">
<link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
<div id="wrapper">
  <?php
  require("header.php");
  ?>
  <div class="contents">
      <table>
        <tr>
          <th>登録者名:</th>
          <form action="follow_home.php" name="form" method="post">
          <input type ="hidden" name="id" value="<?=$book_result["Books"]["user_id"]?>">
          <td><a href="javascript:form.submit()"><?= $book_result['Books']['user_name']?></a></td>
          </form>
        </tr>
      <tr>
          <th>書籍名：</th>
          <td><?= $book_result['Books']['title']?></td>
      </tr>
      <tr>
        <th></th>
        <td><img src="https://cover.openbd.jp/<?=$book_result['Books']['isbn']?>.jpg"></td>
      </tr>
      <tr>
          <th>出版社名：</th>
          <td><?= $book_result['Books']['publisher']?></td>
      </tr>

      <tr>
          <th>著者：</th>
          <td><?= $book_result['Books']['author']?></td>
      </tr>

      <tr>
          <th>出版日：</th>
          <td><?= $book_result['Books']['publish_date']?></td>
      </tr>
      <tr>
          <th>内容：</th>
          <td><?= $book_result['Books']['description']?></td>
      </tr>
      <tr>
      <th>感想:</th>
      <td><?= htmlspecialchars($book_result['Books']['impressions'], ENT_QUOTES, "UTF-8");?></td>
    </tr>
      <tr>
        <th>おすすめ度:</th>
      <td><?= $book_result['Books']['recommended']?></td>
    </tr>
      <th>読んだ日付:</th>
      <td><?= $book_result['Books']['read_date']?></td>
    </table>
  </div class="contents">
    <?php
    require("footer.php");
    ?>
</div id="wrapper">
</body>
</html>
