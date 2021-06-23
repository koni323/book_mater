<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");
if(!isset($_SESSION['User'])){
  header('Location: /phpselfmade_konishi/users/login.php');
  exit;
}
try{
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDb();
  // ログアウト処理
  if(isset($_GET['logout'])){
    // セッション破棄
    $_SESSION = array();
    session_destroy();
  }
  // 参照処理
  // print_r ($_POST);
  $result['User'] = $user->findByID($_POST['id']);
  $book_result['Books'] = $user->book_findByID($_POST['id']);
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
<link rel="icon" type="image/png" href="../img/logo.png">
<link rel="stylesheet" type="text/css" href="../css/follow.css">
</head>
<body>
<div id="wrapper">
  <?php
  require("header.php");
  ?>
<div id="side">
      <div id="profile">

        <p>ユーザーネーム</p>
        <p><?php echo ($result['User']['name'])?></p>
        <p>生年月日</p>
        <p><?php echo ($result['User']['birthday'])?></p>
<form action="follow.php" name="form" method="post" id="form">
  <input type ="hidden" name="follow_id" value="<?=$result["User"]['id']?>">
  <input type ="hidden" name="follow_name" value="<?=$result["User"]['name']?>">
  <input type ="hidden" name="follow_birth" value="<?=$result["User"]['birthday']?>">
  <input type="submit" value="フォローする">
</form>

    </div id="profile">
    </div id="side">
    <div id="main">
     <?php if($book_result['Books'] != NULL):?>
      <h>読んだ本</h>
        <table class="book_list">
          <tr>
           <th>読了日</th>
           <th>タイトル</th>
           <th>著者名</th>
           <th>感想</th>
           <th>おすすめ度</th>
           <th></th>
         </tr>

        <?php foreach($book_result['Books'] as $row):?>
        <form action="impression.php" name="form" method="post" id="form">
         <tr>
           <td><?=$row["read_date"]?></td>
           <td><?=$row["title"]?></td>
           <td><?=$row["author"]?></td>
           <td><?=$row["impressions"]?></td>
           <td><?=$row["recommended"]?></td>
           <input type ="hidden" name="id" value="<?=$row["id"]?>">
           <td> <input class="submit_btn" type="submit" value="詳細を見る"></form></td>
         </tr>
       <?php endforeach; ?>
       </form>
        </table>
       <?php endif;?>
      <div class="footer">
        <p><a href="?logout=1">Logout</a></p>
      </div>
    </div id="main">
</div id="wrapper">
</body>
</html>
