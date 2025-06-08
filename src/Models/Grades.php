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
}

?>