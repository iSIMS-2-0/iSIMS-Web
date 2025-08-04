<?php
require_once __DIR__ . '/../Models/Registration.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Services/AuthService.php';

class RegistrationController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showManageSection() {
        AuthService::requireAuth();
        $currentUser = AuthService::getCurrentUser();
        $student_id = $currentUser['student_id'];

        $registrationModel = new Registration($this->pdo);
        $userModel = new User($this->pdo);

        // Get student information
        $student = $userModel->findByStudentNumber($currentUser['student_number']);
        $program = $userModel->findProgramById($student['id']);
        
        // Get program name properly 
        $programName = is_array($program) ? $program['program_name'] : $program;

        // Get current enrollment information
        $currentEnrollment = $registrationModel->getCurrentEnrollment($student_id);
        
        // Get student's registered subjects for current term
        $registeredSubjects = $registrationModel->getRegisteredSubjects($student_id);

        // Calculate total units
        $totalUnits = array_sum(array_column($registeredSubjects, 'units'));

        // Get current academic year and term
        $currentAcademicYear = $this->getCurrentAcademicYear();
        $currentTerm = $currentEnrollment['term'] ?? 1;
        $currentSchoolYear = $currentEnrollment['school_year'] ?? $currentAcademicYear;

        // Determine year level based on enrollment data or calculate from term
        $yearLevel = $this->determineYearLevel($student_id, $currentTerm);
        
        // Get section information
        $sectionInfo = $registrationModel->getStudentSection($student_id, $currentTerm, $currentSchoolYear);
        
        // Get student status
        $studentStatus = $registrationModel->getStudentStatus($student_id);

        // Pass data to the view
        require __DIR__ . '/../Views/Registration/manageSection.php';
    }

    private function getCurrentAcademicYear() {
        // use the database
        $stmt = $this->pdo->query("SELECT school_year FROM school_years WHERE is_current = 1 LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['school_year'];
        }
    }

    private function determineYearLevel($student_id, $currentTerm) {
        // This is a simplified approach - you might want to add a year_level field to students table
        // For now, calculating based on enrollment patterns
        $registrationModel = new Registration($this->pdo);
        $enrollmentHistory = $registrationModel->getEnrollmentHistory($student_id);
        
        // Count unique school years to estimate year level
        $uniqueYears = array_unique(array_column($enrollmentHistory, 'school_year'));
        $yearLevel = count($uniqueYears);
        
        // Cap at 4th year and ensure minimum 1st year
        return max(1, min(4, $yearLevel));
    }
}
?>
