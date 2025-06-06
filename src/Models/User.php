<?php
class User {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
public function findByStudentNumber($student_number) {
    $stmt = $this->pdo->prepare('SELECT * FROM students WHERE student_number = :student_number');
    $stmt->execute(['student_number' => $student_number]);
    return $stmt->fetch();
}

public function createUser($student_number, $name, $program, $sex, $gender_disclosure, $mobile, $landline, $email, $address, $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $this->pdo->prepare('
        INSERT INTO students 
        (student_number, name, program, sex, gender_disclosure, mobile, landline, email, address, password_hash) 
        VALUES 
        (:student_number, :name, :program, :sex, :gender_disclosure, :mobile, :landline, :email, :address, :password_hash)
    ');
    $stmt->execute([
        'student_number' => $student_number,
        'name' => $name,
        'program' => $program,
        'sex' => $sex,
        'gender_disclosure' => $gender_disclosure,
        'mobile' => $mobile,
        'landline' => $landline,
        'email' => $email,
        'address' => $address,
        'password_hash' => $hashedPassword
    ]);
  }
}
?>