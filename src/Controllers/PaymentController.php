<?php
require_once __DIR__ . '/../Helpers/SchoolYearHelpers.php';
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
        $current = getCurrentSchoolYearAndTerm($this->pdo);
        // Pass $current to the view as needed
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
        $current = getCurrentSchoolYearAndTerm($this->pdo);
        // Use $current['school_year'] and $current['term'] for queries

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

        // Handle file upload for any payment proof row (dynamic input names)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
            foreach ($_FILES as $inputName => $fileInfo) {
                if (strpos($inputName, 'tuition_due_upload_') === 0 && $fileInfo['error'] === UPLOAD_ERR_OK) {
                    // Extract payment proof ID from input name
                    $proofId = (int)str_replace('tuition_due_upload_', '', $inputName);
                    $fileTmpPath = $fileInfo['tmp_name'];
                    $fileName = $fileInfo['name'];
                    $fileType = $fileInfo['type'];
                    $fileSize = $fileInfo['size'];
                    $fileContent = file_get_contents($fileTmpPath);
                    // Update the payment_proofs row with new file and set status to Pending
                    $updateStmt = $this->pdo->prepare("UPDATE payment_proofs SET file_name = ?, file_type = ?, file_size = ?, file_blob = ?, status = ?, upload_date = NOW() WHERE id = ?");
                    $updateStmt->execute([
                        $fileName,
                        $fileType,
                        $fileSize,
                        $fileContent,
                        'Pending',
                        $proofId
                    ]);
                    // Redirect to avoid form resubmission
                    header("Location: /public/index.php?page=onlinepayment");
                    exit();
                }
            }
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

        // Insert or update the Tuition Fee row in payment_proofs
        if (!empty($student_id) && !empty($currentSchoolYear) && !empty($currentTerm)) {
            // Check if a Tuition Fee row exists for this student/term/year
            $stmt = $this->pdo->prepare("SELECT id, amount FROM payment_proofs WHERE student_id = ? AND school_year = ? AND term = ? AND payment_description = 'Tuition Fee' LIMIT 1");
            $stmt->execute([$student_id, $currentSchoolYear, $currentTerm]);
            $tuitionRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($tuitionRow) {
                // Update only the amount if it has changed (do not touch file columns)
                if ((float)$tuitionRow['amount'] !== (float)$totalTuition) {
                    $stmt = $this->pdo->prepare("UPDATE payment_proofs SET amount = ? WHERE id = ?");
                    $stmt->execute([$totalTuition, $tuitionRow['id']]);
                }
            } else {
                // Insert new Tuition Fee row (status: Due) with safe placeholders for file columns (NOT NULL)
                $safeFileName = 'tuition_placeholder.pdf';
                $safeFileType = 'application/pdf';
                $safeFileSize = 1;
                $safeFileBlob = ' '; // single space as a non-empty blob
                $stmt = $this->pdo->prepare("INSERT INTO payment_proofs (student_id, payment_description, school_year, term, amount, status, upload_date, file_name, file_type, file_size, file_blob) VALUES (?, 'Tuition Fee', ?, ?, ?, 'Pending', NOW(), ?, ?, ?, ?)");
                $stmt->execute([$student_id, $currentSchoolYear, $currentTerm, $totalTuition, $safeFileName, $safeFileType, $safeFileSize, $safeFileBlob]);
            }
        }

        // Make variables available to the view
        $paymentProofStatus = $latestProofStatus;
        require __DIR__ . '/../Views/Payment/onlinePayment.php';
    }
}

?>