<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");
if(!isset($_SESSION['User'])){
  header('Location: /phpselfmade_konishi/users/login.php');
    exit;
}
try {
  $user = new User ($host, $dbname, $user, $pass);
  $user->connectdb();
    // 参照処理
    if($_POST){
    $book_result['Books']=$user->book_find($_POST['id']);
  }
  else{
    $book_result['Books'] = NULL;
  }
    if(isset($_GET['del'])){
      $user->book_delete($_GET['del']);
    }
}
  catch(PDOException $e) {
  echo 'データベース接続失敗'.$e->getMessage();
}
?>
﻿<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BOOK　MATER</title>
<link rel="stylesheet" type="text/css" href="../css/registration.css">
<link rel="icon" href="../img/logo.png">
</head>
<body>
  <div id="wrapper">
    <?php
    require("header.php");
    ?>
    <div class="contents">
      <?php if(isset($_GET['edit'])):?>
        <p>更新しました。</p>
        <a href = "home.php">ホームへ戻る</a>
      <?php endif;?>
      <?php if(isset($_GET['del'])):?>
        <p>削除しました。</p>
        <a href = "home.php">ホームへ戻る</a>
      <?php endif;?>
      <?php if($book_result['Books'] != NULL):?>

        <table>
        <tr>
            <th>書籍名：</th>
            <td><input id="title" type="text" name="title" value="<?= $book_result['Books']['title']?>" readonly></td>
        </tr>
        <tr>
          <th></th>
          <td><img src="https://cover.openbd.jp/<?=$book_result['Books']['isbn']?>.jpg"></td>
        </tr>
        <tr>
            <th>出版社名：</th>
            <td><input id="publisher" type="text" name="publisher" value="<?= $book_result['Books']['publisher']?>" readonly></td>
        </tr>

        <tr>
            <th>著者：</th>
            <td><input id="author" type="text" name="author" value="<?= $book_result['Books']['author']?>" readonly></td>
        </tr>

        <tr>
            <th>出版日：</th>
            <td><input id="publish_date" type="text"  name="publish_date" value="<?= $book_result['Books']['publish_date']?>" readonly></td>
        </tr>
        <tr>
            <th>内容：</th>
            <td><textarea id="description" type="text" name="description" cols="85" rows="3" readonly><?= $book_result['Books']['description']?></textarea></td>
        </tr>
        <form action="update.php" name="form" method="post" id="form">
        <tr>
        <th>感想:</th>
        <td><textarea name="impressions" cols="85" rows="15" id="impressions"><?= htmlspecialchars($book_result['Books']['impressions'], ENT_QUOTES, "UTF-8")?></textarea></td>
      </tr>
        <tr>
          <th>おすすめ度</th>
        <td>
          <input type="radio" name="recommended" value = "0"/>0
          <input type="radio" name="recommended" value = "1"/>1
          <input type="radio" name="recommended" value = "2"/>2
          <input type="radio" name="recommended" value = "3"/>3
          <input type="radio" name="recommended" value = "4"/>4
          <input type="radio" name="recommended" value = "5"/>5
        </td>
      </tr>
        <th>
          読んだ日付
        </th>
        <td><input type="date" name="read_date" value="<?= $book_result['Books']['read_date']?>"></td>
      </table>
      <input type = "hidden" name = "id" value = "<?= $book_result['Books']['id']?>">
      <input class="submit_btn" type="submit" value="更新">
      </form>
      <button><a href="?del=<?=$book_result['Books']['id']?>" onClick="if(!confirm('この登録情報を削除しますがよろしいですか？'))return false;">削除</a></button>

    <?php endif;?>
    </div class="contents">
    <?php
    require("footer.php");
    ?>
  </div id="wrapper">
</body>
</html>
