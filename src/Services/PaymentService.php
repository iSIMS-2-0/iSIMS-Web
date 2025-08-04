<?php

class PaymentService {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Calculate tuition based on registered subjects
     */
    public function calculateTuition(array $registeredSubjects): array {
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

        return [
            'total_tuition' => $totalTuition,
            'lab_count' => $labCount,
            'subject_count' => $subCount,
            'total_units' => $totalUnits,
            'lab_fee' => $labFee,
            'tuition_per_subject' => $tuitionPerSub,
            'misc_fee' => $miscFee
        ];
    }

    /**
     * Handle tuition fee database operations
     */
    public function handleTuitionFeeRecord(int $studentId, string $schoolYear, string $term, float $totalTuition): void {
        // Check if a Tuition Fee row exists for this student/term/year
        $stmt = $this->pdo->prepare("SELECT id, amount FROM payment_proofs WHERE student_id = ? AND school_year = ? AND term = ? AND payment_description = 'Tuition Fee' LIMIT 1");
        $stmt->execute([$studentId, $schoolYear, $term]);
        $tuitionRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tuitionRow) {
            // Update only the amount if it has changed (do not touch file columns)
            if ((float)$tuitionRow['amount'] !== (float)$totalTuition) {
                $stmt = $this->pdo->prepare("UPDATE payment_proofs SET amount = ? WHERE id = ?");
                $stmt->execute([$totalTuition, $tuitionRow['id']]);
            }
        } else {
            // Insert new Tuition Fee row (status: Pending) with safe placeholders for file columns (NOT NULL)
            $safeFileName = 'tuition_placeholder.pdf';
            $safeFileType = 'application/pdf';
            $safeFileSize = 1;
            $safeFileBlob = ' '; // single space as a non-empty blob
            $stmt = $this->pdo->prepare("INSERT INTO payment_proofs (student_id, payment_description, school_year, term, amount, status, upload_date, file_name, file_type, file_size, file_blob) VALUES (?, 'Tuition Fee', ?, ?, ?, 'Pending', NOW(), ?, ?, ?, ?)");
            $stmt->execute([$studentId, $schoolYear, $term, $totalTuition, $safeFileName, $safeFileType, $safeFileSize, $safeFileBlob]);
        }
    }

    /**
     * Handle file upload for payment proofs
     */
    public function handleFileUpload(array $fileInfo, string $inputName): ?array {
        if ($fileInfo['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Extract payment proof ID from input name
        if (strpos($inputName, 'tuition_due_upload_') !== 0) {
            return null;
        }

        $proofId = (int)str_replace('tuition_due_upload_', '', $inputName);
        $fileTmpPath = $fileInfo['tmp_name'];
        $fileName = $fileInfo['name'];
        $fileType = $fileInfo['type'];
        $fileSize = $fileInfo['size'];
        $fileContent = file_get_contents($fileTmpPath);

        // Update the payment_proofs row with new file and set status to Pending
        $updateStmt = $this->pdo->prepare("UPDATE payment_proofs SET file_name = ?, file_type = ?, file_size = ?, file_blob = ?, status = ?, upload_date = NOW() WHERE id = ?");
        $result = $updateStmt->execute([
            $fileName,
            $fileType,
            $fileSize,
            $fileContent,
            'Pending',
            $proofId
        ]);

        return $result ? [
            'proof_id' => $proofId,
            'file_name' => $fileName,
            'file_size' => $fileSize
        ] : null;
    }

    /**
     * Get payment history for a student
     */
    public function getPaymentHistory(int $studentId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM payment_proofs WHERE student_id = ? ORDER BY upload_date DESC");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get latest payment proof status
     */
    public function getLatestPaymentStatus(int $studentId, string $schoolYear, string $term): string {
        $stmt = $this->pdo->prepare("SELECT status FROM payment_proofs WHERE student_id = ? AND school_year = ? AND term = ? ORDER BY upload_date DESC LIMIT 1");
        $stmt->execute([$studentId, $schoolYear, $term]);
        $latestProof = $stmt->fetch(PDO::FETCH_ASSOC);
        return $latestProof ? ucfirst($latestProof['status']) : '';
    }
}
