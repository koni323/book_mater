<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");

try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectdb();
  // $result = $user->findAll();
  if($_POST) {
      $message = $user->validate($_POST);
      if(empty($message['name']) && empty($message['password'])&& empty($message['email'])) {
        $result = $user->add($_POST);
        $_SESSION['User'] = $result;
        header('location: ../php/home.php');
        exit;
      }
  }
}catch(PDOException $e) {
  echo 'データベース接続失敗'.$e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BOOK　MATER</title>
<link rel="stylesheet" type="text/css" href="../css/signin.css">
<link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
  <div id="wrapper">
    <div class="header">
      <div id="logo">
      <a href="home.php">
       <img src="../img/logo.png">
       <h class="title">BOOK MATER</h>
      </a>
      </div id="logo">
      <div id="menu">
      <ul>
        <li>
          <a href="../php/home.php">ホーム</a>
        </li>
        <li>
          <a href="../php/registration.php">本の登録</a>
        </li>
        <li>
          <a href="../php/follow.php">フォロー一覧</a>
        </li>
        <li>
          <a href="../php/post.php">本を探す</a>
        </li>
      </ul>
    </div id="menu">
  </div class="header">
    <div class="contents">
      <p>サインイン</p>
      <?php if(isset($message['name'])) echo "<p clas='error'>".$message['name']."</p>" ?>
      <?php if(isset($message['email'])) echo "<p clas='error'>".$message['email']."</p>" ?>
      <?php if(isset($message['password'])) echo "<p class='error'>".$message['password']."</p>" ?>

      <div id="form_area">
        <form class="sign_form" name="form" action ="" method="POST">
          <label id="name">ユーザー名：<input type="text" name="name" size="20" value=""></label>
          <label id="name">メールアドレス:<input type="text" name="email" size="20" value=""></label>
          <label id="name">生年月日:<input type="date" name="birthday" size="20" value="2000-01-01"></label>
          <label id="password">パスワード：<input type="text" name="password" size="10" value=""></label>
          <input class="submit_btn" type="submit" value="送信">
        </form>
    </div>
</form>
     <a href="login.php">ログイン</a>
 </div>
  </div id="wrapper">
</body>
</html>
