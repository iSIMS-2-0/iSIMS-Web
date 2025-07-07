<?php
class Curriculum {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getStudentProgram($student_id) {
        $stmt = $this->pdo->prepare("SELECT program_id FROM students WHERE id = ?");
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCurriculumSubjects($program_id) {
        $stmt = $this->pdo->prepare("
            SELECT s.code, s.name, s.units, c.year_level, c.term_number
            FROM curriculum c 
            JOIN subjects s ON c.subjectid = s.id 
            WHERE c.programid = ? 
            ORDER BY c.year_level ASC, c.term_number ASC, s.code ASC
        ");
        $stmt->execute([$program_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnrolledSubjects($student_id) {
        $stmt = $this->pdo->prepare("
            SELECT s.code, sc.term, sc.school_year
            FROM students_class sc
            JOIN subjects s ON sc.subject_id = s.id
            WHERE sc.student_id = ?
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompletedSubjects($student_id) {
        $stmt = $this->pdo->prepare("
            SELECT s.code, g.grade, sc.term, sc.school_year
            FROM students_class sc
            JOIN subjects s ON sc.subject_id = s.id
            JOIN grades g ON g.students_class_id = sc.id
            WHERE sc.student_id = ?
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrentEnrollment($student_id) {
        $stmt = $this->pdo->prepare("
            SELECT term, school_year 
            FROM students_class 
            WHERE student_id = ? 
            ORDER BY school_year DESC, term DESC 
            LIMIT 1
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
