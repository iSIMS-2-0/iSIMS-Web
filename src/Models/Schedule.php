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

    /**
     * Get the student's schedule for the latest/current term and school year
     */
    public function getStudentScheduleForCurrentTerm($student_id) {
        // Get the latest/current term and school year for this student
        $stmt = $this->pdo->prepare("SELECT sc.term, sc.school_year FROM student_class sc WHERE sc.student_id = ? ORDER BY sc.school_year DESC, FIELD(sc.term, '1st Term', '2nd Term', '3rd Term') DESC LIMIT 1");
        $stmt->execute([$student_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_term = $row['term'] ?? null;
        $current_sy = $row['school_year'] ?? null;
        if ($current_term && $current_sy) {
            $studentSchedules = $this->pdo->prepare("SELECT s.*, sc.term, sc.school_year, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name FROM students_schedule ss JOIN schedules s ON ss.schedule_id = s.id JOIN student_class sc ON sc.student_id = ss.student_id AND sc.subject_id = s.subject_id AND sc.section_id = s.section_id JOIN subjects sub ON s.subject_id = sub.id JOIN sections sec ON s.section_id = sec.id WHERE ss.student_id = ? AND sc.term = ? AND sc.school_year = ?");
            $studentSchedules->execute([$student_id, $current_term, $current_sy]);
            return $studentSchedules->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}
?>