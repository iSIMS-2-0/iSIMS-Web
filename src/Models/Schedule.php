<?php
class Schedule {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByStudentNumber($student_number) {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE id = :student_number');
        $stmt->execute(['student_number' => $student_number]);
        return $stmt->fetch();
    }

    public function findScheduleByStudentNumber($student_number) {
        $stmt = $this->pdo->prepare('SELECT * FROM schedules WHERE id = :student_number');
        $stmt->execute(['student_number' => $student_number]);
        return $stmt->fetchAll();
    }

    
}
?>