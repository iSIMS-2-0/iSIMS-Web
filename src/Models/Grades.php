<?php
class Grades {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByStudentNumber($student_number) {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE student_number = :student_number');
        $stmt->execute(['student_number' => $student_number]);
        return $stmt->fetch();
    }

    public function findGradesByStudentNumber($student_number) {
        $stmt = $this->pdo->prepare('SELECT * FROM grades WHERE id = :student_number');
        $stmt->execute(['student_number' => $student_number]);
        return $stmt->fetchAll();
    }
    /*
    GradeData:
    student_id: foregin_key
    subject_id: foreign_key
    section_id: foreign_key
    term: varchar(20)
    school_year: varchar(20)
    grade: decimal(4,2)
    */
    public function addGrade($studentId, $subjectId, $sectionId, $gradeData) {
        $stmt = $this->pdo->prepare("INSERT INTO grades (student_id, subject_id, section_id, term, school_year, grade) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $studentId,
            $subjectId,
            $sectionId,
            $gradeData['term'],
            $gradeData['school_year'],
            $gradeData['grade']
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Get all grades for a student for a specific term and school year, including subject and section info
     */
    public function getStudentGrades($student_id, $term, $school_year) {
        $stmt = $this->pdo->prepare("SELECT sc.*, sub.code AS subject_code, sub.name AS subject_name, sec.name AS section_name, sub.units, g.grade FROM student_class sc JOIN subjects sub ON sc.subject_id = sub.id JOIN sections sec ON sc.section_id = sec.id LEFT JOIN grades g ON g.student_class_id = sc.id WHERE sc.student_id = ? AND sc.term = ? AND sc.school_year = ?");
        $stmt->execute([$student_id, $term, $school_year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>