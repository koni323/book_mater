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
  // ログアウト処理
  if(isset($_GET['logout'])){
    // セッション破棄
    $_SESSION = array();
    session_destroy();
  }
  // 参照処理
  $result['User'] = $user->findByID($result['User']['id']);
  $book_result['Books'] = $user->book_findByID($result['User']['id']);

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
<link rel="stylesheet" type="text/css" href="../css/home.css">
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


    </div id="profile">
    </div id="side">
    <div id="main">
      <?php if(empty($book_result['Books'])):?>
        <p style="font-weight:bold;">登録情報がまだありません、読んだ本を登録しましょう。</p>
      <?php endif;?>
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
        <form action="edit.php" name="form" method="post" id="form">
         <tr>
           <td><?=$row["read_date"]?></td>
           <td><?=$row["title"]?></td>
           <td><?=$row["author"]?></td>
           <td><?=htmlspecialchars($row["impressions"], ENT_QUOTES, "UTF-8");?></td>
           <td><?=$row["recommended"]?></td>
           <input type ="hidden" name="id" value="<?=$row["id"]?>">
           <td> <input class="submit_btn" type="submit" value="編集、削除"></form></td>
         </tr>
       <?php endforeach; ?>
       </form>
        </table>
       <?php endif;?>
      <div class="footer">
        <?php if(($result['User']['role']) == 1):?>
          <form action="manage.php" name="form" method="post">
          <input type ="hidden" name="id" value="<?=$result["User"]["role"]?>">
        <p><a href="javascript:form.submit()">管理画面へ</a></p>
        <?php endif;?>
        <p><a href="?logout=1">Logout</a></p>
      </div>
    </div id="main">
</div id="wrapper">
</body>
</html>
