<?php
class Subjects {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByStudentNumber($student_number) {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE student_number = :student_number');
        $stmt->execute(['student_number' => $student_number]);
        return $stmt->fetch();
    }


    public function addNewSubject($subjectData) {
        $stmt = $this->pdo->prepare("INSERT INTO subjects (grade_id, code, name, units) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $subjectData['grade_id'],
            $subjectData['code'],
            $subjectData['name'],
            $subjectData['units']
        ]);
        return $this->pdo->lastInsertId();
    }

}


?>