<?php 
class Database{
  protected $pdo;
  public function __construct() {

    $dsn = "mysql:host=localhost;dbname=2_OOP_attendance_system;charset=utf8";
    $user = "root";
    $password = "";
    try {
      $this->pdo = new PDO($dsn,$user,$password);

      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        }
    }
  public function create($query, $params){
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute($params);
  }
  public function read($query, $params = []){
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
  }
  public function update($query, $params){
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute($params);
  }
  public function delete($query, $params){
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute($params);
  }
}

?>