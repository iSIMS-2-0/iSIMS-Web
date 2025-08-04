<?php
require_once __DIR__ . '/../Models/Curriculum.php';
require_once __DIR__ . '/../Services/AuthService.php';

class CurriculumController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showCurriculum() {
        AuthService::requireAuth();
        $currentUser = AuthService::getCurrentUser();
        $student_id = $currentUser['student_id'];

        $curriculumModel = new Curriculum($this->pdo);

        // Get student's program
        $student = $curriculumModel->getStudentProgram($student_id);
        $program_id = $student['program_id'];

        // Get curriculum subjects for the student's program with year and term info
        $curriculumSubjects = $curriculumModel->getCurriculumSubjects($program_id);

        // Get student's enrollment and grade data
        $enrolledSubjects = $curriculumModel->getEnrolledSubjects($student_id);
        $completedSubjects = $curriculumModel->getCompletedSubjects($student_id);

        // Create lookup arrays for status checking
        $enrolledLookup = [];
        foreach ($enrolledSubjects as $enrolled) {
            $enrolledLookup[$enrolled['code']] = [
                'term' => $enrolled['term'],
                'school_year' => $enrolled['school_year']
            ];
        }

        $completedLookup = [];
        foreach ($completedSubjects as $completed) {
            $completedLookup[$completed['code']] = [
                'grade' => $completed['grade'],
                'term' => $completed['term'],
                'school_year' => $completed['school_year']
            ];
        }

        // Organize subjects by year and term dynamically from database
        $subjectsByYearTerm = [];
        foreach ($curriculumSubjects as $subject) {
            $year = $subject['year_level'] ?? 1;
            $term = $subject['term_number'] ?? 1;
            
            $yearText = $this->getYearText($year);
            $termText = $this->getTermText($term);
            
            if (!isset($subjectsByYearTerm[$yearText])) {
                $subjectsByYearTerm[$yearText] = [];
            }
            if (!isset($subjectsByYearTerm[$yearText][$termText])) {
                $subjectsByYearTerm[$yearText][$termText] = [];
            }
            
            $subjectsByYearTerm[$yearText][$termText][] = $subject;
        }

        // Create a lookup array for quick subject access
        $subjectLookup = [];
        foreach ($curriculumSubjects as $subject) {
            $subjectLookup[$subject['code']] = $subject;
        }

        // Get selected filters
        $selectedYear = $_GET['school-year'] ?? '';
        $selectedTerm = $_GET['year-term'] ?? '';

        // Pass data to the view
        require __DIR__ . '/../Views/Registration/curriculum.php';
    }

    // Helper functions
    private function getYearText($yearNumber) {
        $years = [1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'];
        return $years[$yearNumber] ?? "{$yearNumber}th Year";
    }

    private function getTermText($termNumber) {
        $terms = [1 => '1st Term', 2 => '2nd Term', 3 => '3rd Term'];
        return $terms[$termNumber] ?? "{$termNumber}th Term";
    }

    private function getTermNumber($termText) {
        return str_replace(['1st Term', '2nd Term', '3rd Term'], ['1st term', '2nd term', '3rd term'], $termText);
    }

    // Function to determine subject status and return appropriate CSS class
    public function getSubjectStatus($subjectCode, $enrolledLookup, $completedLookup) {
        // Priority 1: Check if subject has been completed with a grade
        if (isset($completedLookup[$subjectCode])) {
            $grade = $completedLookup[$subjectCode]['grade'];
            // Assuming passing grade is 3.0 or below (Filipino grading system where 1.0 is highest, 5.0 is fail)
            if ($grade <= 3.0) {
                return 'passed'; // Already passed
            } else {
                return 'failed'; // Failed
            }
        }
        
        // Priority 2: Check if subject is currently enrolled
        if (isset($enrolledLookup[$subjectCode])) {
            return 'enrolled'; // Currently enrolled
        }
        
        // Priority 3: Default to not taken
        return 'not-taken'; // Not yet taken
    }
}
?>
