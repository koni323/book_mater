<?php
require_once("DB.php");

class User extends DB {

// XSS対策
   public function h($s) {
   return nl2br(htmlspecialchars($s, ENT_QUOTES, "UTF-8"));
   }

  // ログイン
    public function login($arr) {
      $sql = 'SELECT * FROM users WHERE name = :name';
      $stmt = $this->connect->prepare($sql);
      $params = array(':name'=>$arr['name']);
      // ':password'=>$arr['password']);
      $stmt->execute($params);
      // $result = $stmt->rowCount();
      $result = $stmt->fetch();
      return $result;
    }

  //参照 select
  public function findAll(){
    $sql = 'SELECT * FROM users';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }
// 条件つき参照
  public function findByID($id){
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' =>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }


  //サインイン　signin
  public function add($arr){
    $sql = "INSERT INTO users(name, email, birthday, password, created) VALUES(:name, :email,:birthday, :password,:created)";
    $stmt = $this->connect->prepare($sql);
    $hash = password_hash($arr['password'],PASSWORD_BCRYPT);
    $params = array(
      ':name'=>$arr['name'],
      ':email'=>$arr['email'] ,
      ':birthday'=>$arr['birthday'] ,
      ':password'=>$hash,
      ':created'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);

  }

  // 削除 delete
  public function delete($id = null){
    if (isset($id)) {
      $sql = "DELETE FROM user WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id' =>$id);
      $stmt->execute($params);
    }
  }

  //編集 update
  public function edit($arr){
  $sql = "UPDATE contact SET name = :name, email = :email WHERE id = :id";
  $stmt = $this->connect->prepare($sql);
  $params = array(
    ':id'=>$arr['id'],
    ':name'=>$arr['name'],
    ':email'=>$arr['email'] ,
  );
  $stmt->execute($params);
}
// 入力チェック　validate
public function validate($arr){
  $message = array();
  // ユーザー名
if(empty($arr['name'])){
  $message['name'] = 'ユーザー名を入力してください。';
}elseif (mb_strlen($arr['name'])>10) {
  $message['name'] = 'ユーザー名を１０文字以内で入力してください。';
}
  // アドレス
  if(empty($arr['email'])){
    $message['email'] = 'メールアドレスを入力してください。';
  }
  else{
  if (!filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) {
    $message['email'] = 'メールアドレスが正しくありません。';
}
}
if(empty($arr['password'])) {
  $error['password'] = "パスワードを入力してください";
}
  return $message;
}
//登録　insert
public function book_add($arr){
  $sql = "INSERT INTO books(user_id, user_name, isbn, title, author, publisher, publish_date, description, impressions,recommended, read_date) VALUES(:user_id, :user_name, :isbn, :title,:author, :publisher, :publish_date, :description, :impressions,:recommended, :read_date)";
  $stmt = $this->connect->prepare($sql);
  $params = array(
    ':user_id'=>$_SESSION['User']['id'],
    ':user_name'=>$_SESSION['User']['name'],
    ':isbn'=>$arr['isbn'],
    ':title'=>$arr['title'] ,
    ':publisher'=>$arr['publisher'],
    ':author'=>$arr['author'],
    ':publish_date'=>$arr['publish_date'],
    ':description'=>$arr['description'],
    ':impressions'=>$arr['impressions'],
    ':recommended'=>$arr['recommended'],
    ':read_date'=>$arr['read_date']
  );
  $stmt->execute($params);
}
// 条件つき参照
  public function book_findByID($user_id){
    $sql = "SELECT * FROM books WHERE user_id = :user_id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id' =>$user_id);
    $stmt->execute($params);
    $book_result = $stmt->fetchAll();
    return $book_result;
  }

  // 条件つき参照
    public function book_find($id){
      $sql = "SELECT * FROM books WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id' =>$id);
      $stmt->execute($params);
      $book_result = $stmt->fetch();
      return $book_result;
    }
  //参照 select
  public function book_findAll(){
    $sql = 'SELECT * FROM books';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $book_result = $stmt->fetchAll();

    return $book_result;
  }
  // 削除 delete
  public function book_delete($id = null){
    if (isset($id)) {
      $sql = "DELETE FROM books WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id' =>$id);
      $stmt->execute($params);
    }
  }

  //編集 update
  public function book_edit($arr){
  $sql = "UPDATE books SET impressions=:impressions,recommended=:recommended, read_date=:read_date WHERE id = :id";
  $stmt = $this->connect->prepare($sql);
  $params = array(
    ':id'=>$arr['id'],
    ':impressions'=>$arr['impressions'],
    ':recommended'=>$arr['recommended'],
    ':read_date'=>$arr['read_date'] ,
  );
  $stmt->execute($params);
}

// follow

public function follow_delete($id = null){
  if (isset($id)) {
    $sql = "DELETE FROM follow WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' =>$id);
    $stmt->execute($params);
  }
}

public function follow_add($arr){
  $sql = "INSERT INTO follow(user_id, follow_id, follow_name, follow_birth) VALUES(:user_id,:follow_id, :follow_name, :follow_birth)";
  $stmt = $this->connect->prepare($sql);
  $params = array(
    ':user_id'=>$_SESSION['User']['id'],
    ':follow_id'=>$arr['follow_id'],
    ':follow_name'=>$arr['follow_name'],
    ':follow_birth'=>$arr['follow_birth']
  );
  $stmt->execute($params);

}
// 条件つき参照
  public function follow_findByID($user_id){
    $sql = "SELECT * FROM follow WHERE user_id = :user_id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id' =>$user_id);
    $stmt->execute($params);
    $book_result = $stmt->fetchAll();
    return $book_result;
  }

}

?>
