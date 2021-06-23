<?php
require_once("../config/config.php");
require_once("../model/User.php");
// if($result['User']['role']!=1){
//   header('Location: /phpselfmade_konishi/php/home.php');
//   exit;
// }
try{
  $user = new User($host,$dbname,$user,$pass);
  $user->connectDb();

// 削除処理
if(isset($_GET['del'])){
  $user->delete($_GET['del']);
  $result = $user->findAll();
}
  // 参照処理
  $result = $user->findAll();
}
catch (PDOException $e) {
  echo "エラー!: " . $e->getMessage();
}

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BOOK　MATER</title>
<link rel="stylesheet" type="text/css" href="../css/manage.css">
</head>
<body>
  <div id="wrapper">
    <?php
    require("header.php");
    ?>
    <div id="contents">
      <table>
       <tr>
         <th>ユーザーID</th>
         <th>ユーザー名</th>
         <th>メールアドレス</th>
         <th>生年月日</th>
         <th>パスワード</th>
         <th>登録日時</th>
         <th>削除</th>
       </tr>
    <?php foreach($result as $row): ?>
<tr>
    <td><?=$row["id"]?></td>
    <td><?=$row["name"]?></td>
    <td><?=$row["email"]?></td>
    <td><?=$row["birthday"]?></td>
    <td><?=$row["password"]?></td>
    <td><?=$row["created"]?></td>
    <td>
     <a href="?del=<?=$row['id']?>" onClick="if(!confirm('ID:<?=$row['id']?>を削除しますがよろしいですか？'))return false;">削除</a>
    </td>
</tr>
<?php endforeach;?>
    </table>
    </div id="contents">
    <?php
    require("footer.php");
    ?>
  </div id="wrapper">
</body>
</html>
