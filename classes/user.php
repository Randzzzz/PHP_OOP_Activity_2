<?php 
require_once "../core/database.php";

class User extends Database{
  public function register($username, $first_name, $last_name, $password, $role){
    $query = "INSERT INTO users (username, first_name, last_name, password, role) VALUES (:username, :first_name, :last_name, :password, :role)";
    return $this->create($query, [':username' => $username, ':first_name' => $first_name, ':last_name' => $last_name,':password' => password_hash($password, PASSWORD_BCRYPT), ':role' => $role]);
  }
  public function login($username, $password){
    $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $user = $this->read($query, [':username' => $username]);

    if($user && password_verify($password, $user[0]['password'])){
      return $user[0];
    } else {
      return false;
    }
  }
}
?>