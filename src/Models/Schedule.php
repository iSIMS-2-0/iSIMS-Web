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
    
    public function getStudentScheduleById($student_id) {
        // fetches from students_schedule table
        $stmt = $this->pdo->prepare('SELECT * FROM students_schedule WHERE student_id = :student_id');
        $stmt->execute(['student_id' => $student_id]);
        return $stmt->fetchAll();
    }
    
}
?>