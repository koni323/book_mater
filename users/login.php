<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");
try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectdb();
  if($_POST) {
     $result = $user->login($_POST);
    if(!empty($result)){
     if(password_verify($_POST['password'], $result['password'])){
     $_SESSION['User'] = $result;
      header('Location: /phpselfmade_konishi/php/home.php');
      exit;
    }
  }
    else {
      $message = "ログイン出来ませんでした";
    }
  }

}catch(PDOException $e) {
  echo 'エラー'.$e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BOOK　MATER</title>
<link rel="stylesheet" type="text/css" href="../css/login.css">
<link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
  <div id="wrapper">
    <div class="contents">
      <div class="header">
        <div id="logo">
        <a href="../php/home.php">
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
   <div class="login_form">
     <p>ログインするには以下にユーザー名とパスワードを入力して下さい。</p>
   </br>
     <form class="log_form" name ="form" action="" method="POST">
       <labl>ユーザー名: <input type="text" name="name" size="20"></labl>
       <labl>パスワード: <input type="password" name="password" size="20"></labl>
       <input class="log_sub" type="submit" value="送信">
     </form>
    </div>

    <a href="signin.php">サインイン</a>
</div>
  </div id="wrapper">
</body>
</html>
