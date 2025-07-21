<?php
class PaymentController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showERF() {
        // Start session to check if user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Render the ERF view
        require __DIR__ . '/../Views/Payment/erf.php';
    }

    public function showPaymentHistory() {
        // Start session to check if user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Setup models using $this->pdo
        require_once __DIR__ . '/../Models/Registration.php';
        require_once __DIR__ . '/../Models/User.php';
        $registrationModel = new Registration($this->pdo);
        $userModel = new User($this->pdo);
        $student_id = $_SESSION['student_id'];

        // Get student information
        $student = $userModel->findByStudentNumber($_SESSION['student_number']);

        // Fetch all payment history for this student
        $stmt = $this->pdo->prepare("SELECT * FROM payment_proofs WHERE student_id = ? ORDER BY upload_date DESC");
        $stmt->execute([$student_id]);
        $paymentHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Render the payment history view
        require __DIR__ . '/../Views/Payment/paymentHistory.php';
    }

    public function showOnlinePayment() {
        // Start session to check if user is logged in
        session_start();
        if (!isset($_SESSION['student_number'])) {
            // If not logged in, redirect to the login page
            header("Location: /public/index.php?page=login");
            exit();
        }

        // Setup models using $this->pdo
        require_once __DIR__ . '/../Models/Registration.php';
        require_once __DIR__ . '/../Models/User.php';
        $registrationModel = new Registration($this->pdo);
        $userModel = new User($this->pdo);
        $student_id = $_SESSION['student_id'];

        // Fetch all payment history for this student (for display in onlinePayment.php)
        $stmt = $this->pdo->prepare("SELECT * FROM payment_proofs WHERE student_id = ? ORDER BY upload_date ASC");
        $stmt->execute([$student_id]);
        $paymentHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Handle file upload for proof of payment
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['tuition_due_upload']) && $_FILES['tuition_due_upload']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['tuition_due_upload']['tmp_name'];
            $fileName = $_FILES['tuition_due_upload']['name'];
            $fileType = $_FILES['tuition_due_upload']['type'];
            $fileSize = $_FILES['tuition_due_upload']['size'];
            $fileContent = file_get_contents($fileTmpPath);

            $currentEnrollment = $registrationModel->getCurrentEnrollment($student_id);
            $currentSchoolYear = $currentEnrollment['school_year'] ?? '';
            $currentTerm = $currentEnrollment['term'] ?? '';
            $paymentDescription = 'Tuition Fee';

            // Calculate tuition amount for this upload
            $registeredSubjects = $registrationModel->getRegisteredSubjects($student_id);
            $labFee = 6620;
            $tuitionPerSub = 7692;
            $miscFee = 19920;
            $labCount = 0;
            $subCount = 0;
            if (!empty($registeredSubjects)) {
                foreach ($registeredSubjects as $subject) {
                    if (!empty($subject['is_laboratory']) && $subject['is_laboratory']) {
                        $labCount++;
                    }
                    $subCount++;
                }
                $totalTuition = ($labFee * $labCount) + ($tuitionPerSub * $subCount) + $miscFee;
            } else {
                $totalTuition = 0;
            }

            $stmt = $this->pdo->prepare("INSERT INTO payment_proofs (student_id, payment_description, school_year, term, amount, file_name, file_type, file_size, file_blob, status, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([
                $student_id,
                $paymentDescription,
                $currentSchoolYear,
                $currentTerm,
                $totalTuition,
                $fileName,
                $fileType,
                $fileSize,
                $fileContent,
                'Pending'
            ]);
            // Redirect to avoid form resubmission on refresh (POST-Redirect-GET)
            header("Location: /public/index.php?page=onlinePayment");
            exit();
        }

        // Get student information
        $student = $userModel->findByStudentNumber($_SESSION['student_number']);
        $program = $userModel->findProgramById($student['id']);
        $programName = is_array($program) ? $program['program_name'] : $program;

        // Get current enrollment information
        $currentEnrollment = $registrationModel->getCurrentEnrollment($student_id);
        $currentSchoolYear = $currentEnrollment['school_year'] ?? '';
        $currentTerm = $currentEnrollment['term'] ?? '';
        $yearLevel = $currentEnrollment['year_level'] ?? '';
        $studentStatus = $registrationModel->getStudentStatus($student_id) ?? '';

        // Get student's registered subjects for current term
        $registeredSubjects = $registrationModel->getRegisteredSubjects($student_id);

        // Fetch latest payment proof for this student, current term and school year
        $latestProofStatus = '';
        if (!empty($student_id) && !empty($currentSchoolYear) && !empty($currentTerm)) {
            $stmt = $this->pdo->prepare("SELECT status FROM payment_proofs WHERE student_id = ? AND school_year = ? AND term = ? ORDER BY upload_date DESC LIMIT 1");
            $stmt->execute([$student_id, $currentSchoolYear, $currentTerm]);
            $latestProof = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($latestProof) {
                $latestProofStatus = ucfirst($latestProof['status']);
            }
        }

        // Tuition calculation variables (for use in view)
        $labFee = 6620;
        $tuitionPerSub = 7692;
        $miscFee = 19920;
        $labCount = 0;
        $subCount = 0;
        $totalUnits = 0;
        if (!empty($registeredSubjects)) {
            foreach ($registeredSubjects as $subject) {
                if (!empty($subject['is_laboratory']) && $subject['is_laboratory']) {
                    $labCount++;
                }
                $subCount++;
                $totalUnits += (int)($subject['units'] ?? 0);
            }
            $totalTuition = ($labFee * $labCount) + ($tuitionPerSub * $subCount) + $miscFee;
        } else {
            $totalTuition = 0;
        }

        // Make variables available to the view
        $paymentProofStatus = $latestProofStatus;
        require __DIR__ . '/../Views/Payment/onlinePayment.php';
    }
}

?>