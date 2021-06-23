<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");
if(!isset($_SESSION['User'])){
  header('Location: /phpselfmade_konishi/users/login.php');
    exit;
}
try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectdb();
  if(isset($_GET['logout'])){
    // セッション破棄
    $_SESSION = array();
    session_destroy();
  }
  if($_POST) {
        $result = $user->book_add($_POST);
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
<link rel="icon" type="image/png" href="../img/logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
  <div id="wrapper">
    <?php
    require("header.php");
    ?>
    <div class="contents">
      <form action="" name="form" method="post" id="form">
        <table>
          <tr>
            <th>ISBN13：</th>
            <td><input id="isbn" type="text" name="isbn" value="" autofocus></td>
            <td><button id="getBookInfo" class="btn btn-default">書籍情報取得</button><td>
          </tr>
          <tr>
            <th></th>
        <td>
            <p id="thumbnail"></p>
        </td>
      </tr>
        <tr>
            <th>書籍名：</th>
            <td><input id="title" type="text" name="title" value="" readonly></td>
        </tr>

        <tr>
            <th>出版社名：</th>
            <td><input id="publisher" type="text" name="publisher" value="" readonly></td>
        </tr>

        <tr>
            <th>著者：</th>
            <td><input id="author" type="text" name="author" value="" readonly></td>
        </tr>

        <tr>
            <th>出版日：</th>
            <td><input id="publish_date" type="text"  name="publish_date" value="" readonly></td>
        </tr>
        <tr>
            <th>内容：</th>
            <td><textarea id="description" type="text" name="description" cols="85" rows="3" value="" readonly></textarea></td>
        </tr>
        <tr>
        <th>感想:</th>
        <td><textarea name="impressions" cols="85" rows="15" id="impressions"></textarea></td>
      </tr>
        <tr>
          <th>おすすめ度</th>
        <td>
          <input type="radio" name="recommended" value = "0"/>0
          <input type="radio" name="recommended" value = "1"/>1
          <input type="radio" name="recommended" value = "2"/>2
          <input type="radio" name="recommended" value = "3" checked/>3
          <input type="radio" name="recommended" value = "4"/>4
          <input type="radio" name="recommended" value = "5"/>5
        </td>
      </tr>
        <th>
          読んだ日付
        </th>
        <td><input type="date" name="read_date"></td>
      </table>
          <input class="submit_btn" type="submit" value="登録">
          </form>
    </div class="contents">
    <?php
    require("footer.php");
    ?>
  </div id="wrapper">
  <script>
  $(function() {
      $('#getBookInfo').click( function( e ) {
          e.preventDefault();
          const isbn = $("#isbn").val();
          const url = "https://api.openbd.jp/v1/get?isbn=" + isbn;

          $.getJSON( url, function( data ) {
              if( data[0] == null ) {
                  alert("データが見つかりません");
              } else {
                  if( data[0].summary.cover == "" ){
                      $("#thumbnail").html('<img src=\"\" />');
                  } else {
                      $("#thumbnail").html('<img src=\"' + data[0].summary.cover + '\" style=\"border:solid 1px #000000\" />');
                  }
                  $("#title").val(data[0].summary.title);
                  $("#publisher").val(data[0].summary.publisher);
                  $("#author").val(data[0].summary.author);
                  $("#publish_date").val(data[0].summary.pubdate);
                  $("#cover").val(data[0].summary.cover);
                  $("#description").val(data[0].onix.CollateralDetail.TextContent[0].Text);
              }
          });
      });
  });
</script>
</body>
</html>
