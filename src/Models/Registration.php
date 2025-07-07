<?php
class Registration {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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

    public function getRegisteredSubjects($student_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                s.code,
                s.name,
                s.units,
                sec.name as section_name,
                sc.term,
                sc.school_year,
                GROUP_CONCAT(
                    CONCAT(sch.day_of_week, ' ', 
                           TIME_FORMAT(sch.start_time, '%h:%i %p'), ' - ', 
                           TIME_FORMAT(sch.end_time, '%h:%i %p'), ' ', 
                           COALESCE(sch.room, 'TBA')) 
                    SEPARATOR ', '
                ) as schedule
            FROM students_class sc
            JOIN subjects s ON sc.subject_id = s.id
            JOIN sections sec ON sc.section_id = sec.id
            LEFT JOIN schedules sch ON sch.subject_id = s.id AND sch.section_id = sec.id
            WHERE sc.student_id = ?
            AND sc.school_year = (
                SELECT school_year 
                FROM students_class 
                WHERE student_id = ? 
                ORDER BY school_year DESC, term DESC 
                LIMIT 1
            )
            AND sc.term = (
                SELECT term 
                FROM students_class 
                WHERE student_id = ? 
                ORDER BY school_year DESC, term DESC 
                LIMIT 1
            )
            GROUP BY s.id, sec.id, sc.term, sc.school_year
            ORDER BY s.code
        ");
        $stmt->execute([$student_id, $student_id, $student_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Clean up schedule formatting
        foreach ($result as &$subject) {
            if (empty($subject['schedule']) || $subject['schedule'] === null) {
                $subject['schedule'] = 'TBA';
            }
        }
        
        return $result;
    }

    public function getStudentSection($student_id, $term, $school_year) {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT sec.name as section_name
            FROM students_class sc
            JOIN sections sec ON sc.section_id = sec.id
            WHERE sc.student_id = ? AND sc.term = ? AND sc.school_year = ?
            LIMIT 1
        ");
        $stmt->execute([$student_id, $term, $school_year]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['section_name'] ?? 'Not Assigned';
    }

    public function getEnrollmentHistory($student_id) {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT school_year, term
            FROM students_class
            WHERE student_id = ?
            ORDER BY school_year ASC, term ASC
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentStatus($student_id) {
        // This could be enhanced to check various factors
        // For now, return a simple status based on current enrollment
        $currentEnrollment = $this->getCurrentEnrollment($student_id);
        
        if ($currentEnrollment) {
            return 'Enrolled';
        } else {
            return 'Not Enrolled';
        }
    }
}
?>
