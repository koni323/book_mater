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
  $book_result=$user->book_findAll();
}
catch (PDOException $e) {
  echo "エラー!: " . $e->getMessage();
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BOOK MATER</title>
<link rel="icon" href="../img/logo.png">
<link rel="stylesheet" type="text/css" href="../css/post.css">
</head>
<body>
<div id="wrapper">
  <?php
  require("header.php");
  ?>

  <div id="main">
    <h>投稿一覧</h>
      <table class="book_list">
        <tr>
         <th>ユーザーネーム</th>
         <th>読了日</th>
         <th>タイトル</th>
         <th>著者名</th>
         <th>感想</th>
         <th>おすすめ度</th>
       </tr>
       <?php foreach ($book_result as $row):?>
      <form action="impression.php" name="form" method="post" id="form">
       <tr>
         <td><?=$row["user_name"]?></td>
         <td><?=$row["read_date"]?></td>
         <td><?=$row["title"]?></td>
         <td><?=$row["author"]?></td>
         <td><?=htmlspecialchars($row["impressions"], ENT_QUOTES, "UTF-8");?></td>
         <td><?=$row["recommended"]?></td>
         <input type ="hidden" name="id" value="<?=$row["id"]?>">
         <td> <input class="submit_btn" type="submit" value="詳細を見る"></form></td>
       </tr>
       <?php endforeach; ?>
      </table>
    </div id="main">
    <?php
    require("footer.php");
    ?>
</div id="wrapper">
</body>
</html>
