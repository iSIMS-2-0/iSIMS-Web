<?php
class User {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function findById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
  public function createUser($id, $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password
    $stmt = $this->pdo->prepare('INSERT INTO students (id, password_hash, created_at) VALUES (:id, :password_hash, NOW())');
    $stmt->execute([
        'id' => $id,
        'password_hash' => $hashedPassword
    ]);
  }
}
?>