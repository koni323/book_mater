<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");
if(!isset($_SESSION['User'])){
  header('Location: /phpselfmade_konishi/users/login.php');
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
  // print_r ($_POST['follower_id']);
  if(isset($_POST['follow_id'])){
    $result = $user->follow_add($_POST);
    // print_r ($result);
  }
  $result['Follow'] = $user->follow_findById($_SESSION['User']['id']);
  if(isset($_GET['del'])){
    $user->follow_delete($_GET['del']);
  }
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
<link rel="stylesheet" type="text/css" href="../css/follow.css">
<link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
<div id="wrapper">
  <?php
  require("header.php");
  ?>
  <table>
   <tr>
     <th>ユーザー名</th>
     <th>生年月日</th>
     <th>フォローの解除</th>
   </tr>
    <?php foreach($result['Follow'] as $row):?>
   <tr>
   <form><td><?=$row["follow_name"]?></td>
     <td><?=$row["follow_birth"]?></td>
     <td><a href="?del=<?=$row['id']?>" onClick="if(!confirm('このユーザーのフォローを解除しますがよろしいですか？'))return false;">フォローの解除</a></td>
   </tr>
   <?php endforeach; ?>
  </table>
  <?php
  require("footer.php");
  ?>
</div id="wrapper">
</body>
</html>
