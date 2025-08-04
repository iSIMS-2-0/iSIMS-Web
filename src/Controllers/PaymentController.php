<?php
require_once __DIR__ . '/../Helpers/SchoolYearHelpers.php';
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Services/PaymentService.php';

class PaymentController {
    private $pdo;
    private $paymentService;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->paymentService = new PaymentService($pdo);
    }

    public function showERF() {
        AuthService::requireAuth();
        
        // Render the ERF view
        $current = getCurrentSchoolYearAndTerm($this->pdo);
        require __DIR__ . '/../Views/Payment/erf.php';
    }

    public function showPaymentHistory() {
        AuthService::requireAuth();
        $currentUser = AuthService::getCurrentUser();
        $student_id = $currentUser['student_id'];

        // Setup models using $this->pdo
        require_once __DIR__ . '/../Models/Registration.php';
        require_once __DIR__ . '/../Models/User.php';
        $registrationModel = new Registration($this->pdo);
        $userModel = new User($this->pdo);

        // Get student information
        $student = $userModel->findByStudentNumber($currentUser['student_number']);
        $current = getCurrentSchoolYearAndTerm($this->pdo);

        // Fetch all payment history for this student using the service
        $paymentHistory = $this->paymentService->getPaymentHistory($student_id);

        // Render the payment history view
        require __DIR__ . '/../Views/Payment/paymentHistory.php';
    }

    public function showOnlinePayment() {
        AuthService::requireAuth();
        $currentUser = AuthService::getCurrentUser();
        $student_id = $currentUser['student_id'];

        // Setup models using $this->pdo
        require_once __DIR__ . '/../Models/Registration.php';
        require_once __DIR__ . '/../Models/User.php';
        $registrationModel = new Registration($this->pdo);
        $userModel = new User($this->pdo);

        // Fetch all payment history for this student (for display in onlinePayment.php)
        $paymentHistory = $this->paymentService->getPaymentHistory($student_id);

        // Handle file upload for any payment proof row (dynamic input names)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
            foreach ($_FILES as $inputName => $fileInfo) {
                $uploadResult = $this->paymentService->handleFileUpload($fileInfo, $inputName);
                if ($uploadResult) {
                    // Redirect to avoid form resubmission
                    header("Location: /public/index.php?page=onlinepayment");
                    exit();
                }
            }
        }

        // Get student information
        $student = $userModel->findByStudentNumber($currentUser['student_number']);
        $program = $userModel->findProgramById($student['id']);
        $programName = is_array($program) ? $program['program_name'] : $program;

        // Get current enrollment information
        $currentEnrollment = $registrationModel->getCurrentEnrollment($student_id);
        $currentSchoolYear = $currentEnrollment['school_year'] ?? '';
        $currentTerm = $currentEnrollment['term'] ?? '';
        $yearLevel = $currentEnrollment['year_level'] ?? '';
        $studentStatus = $registrationModel->getStudentStatus($student_id) ?? '';

        // Filter registeredSubjects for current term and school year only
        $allSubjects = $registrationModel->getRegisteredSubjects($student_id);
        $registeredSubjects = [];
        if (!empty($allSubjects) && !empty($currentSchoolYear) && !empty($currentTerm)) {
            foreach ($allSubjects as $subject) {
                // Normalize term for comparison (int or string)
                $subjectTerm = isset($subject['term']) ? (is_numeric($subject['term']) ? (int)$subject['term'] : $subject['term']) : null;
                $currentTermNorm = is_numeric($currentTerm) ? (int)$currentTerm : $currentTerm;
                if (
                    isset($subject['school_year']) && $subject['school_year'] == $currentSchoolYear &&
                    $subjectTerm !== null && $subjectTerm == $currentTermNorm
                ) {
                    $registeredSubjects[] = $subject;
                }
            }
        }

        // Get latest payment status using the service
        $latestProofStatus = '';
        if (!empty($student_id) && !empty($currentSchoolYear) && !empty($currentTerm)) {
            $latestProofStatus = $this->paymentService->getLatestPaymentStatus($student_id, $currentSchoolYear, $currentTerm);
        }

        // Calculate tuition using the service
        $tuitionCalculation = $this->paymentService->calculateTuition($registeredSubjects);
        $totalTuition = $tuitionCalculation['total_tuition'];
        $labCount = $tuitionCalculation['lab_count'];
        $subCount = $tuitionCalculation['subject_count'];
        $totalUnits = $tuitionCalculation['total_units'];
        $labFee = $tuitionCalculation['lab_fee'];
        $tuitionPerSub = $tuitionCalculation['tuition_per_subject'];
        $miscFee = $tuitionCalculation['misc_fee'];

        // Handle tuition fee record using the service
        if (!empty($student_id) && !empty($currentSchoolYear) && !empty($currentTerm)) {
            $this->paymentService->handleTuitionFeeRecord($student_id, $currentSchoolYear, $currentTerm, $totalTuition);
        }

        // Make variables available to the view
        $paymentProofStatus = $latestProofStatus;
        require __DIR__ . '/../Views/Payment/onlinePayment.php';
    }
}

?>