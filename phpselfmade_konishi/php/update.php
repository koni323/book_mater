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
    $user->book_edit($_POST);
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
        <p>更新しました。</p>
        <a href = "home.php">ホームへ戻る</a>
    </div class="contents">
    <?php
    require("footer.php");
    ?>
  </div id="wrapper">
</body>
</html>
