<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Payment/onlinePayment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Online Payment</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Online Payment</h1>

            <div class="student-information">
                <div class="student-name">
                    <h4>Student Name:</h4>
                    <p><?= htmlspecialchars($student['name'] ?? 'N/A') ?></p>
                </div>

                <div class="student-number">
                    <h4>Student Number:</h4>
                    <p><?= htmlspecialchars($student['student_number'] ?? 'N/A') ?></p>
                </div>
            </div>

            <?php // Tuition is already calculated in the controller as $totalTuition ?>

            <form method="post" enctype="multipart/form-data">
                <table class="payment-history-table">
                    <thead>
                        <tr>
                            <th>School Year</th>
                            <th>Term</th>
                            <th>Year Level</th>
                            <th>Scholarship</th>
                            <th>Description</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Upload</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody class="payment-history-table__body">
                        <!-- Tuition Calculation Row -->
                        <tr>
                            <td><?= htmlspecialchars($currentSchoolYear ?? '') ?></td>
                            <td><?= htmlspecialchars($currentTerm ?? '') ?></td>
                            <td><?= htmlspecialchars($yearLevel ?? '') ?></td>
                            <td></td>
                            <td>TOTAL AMOUNT DUE</td>
                            <td></td>
                            <td><?= number_format($totalTuition, 2) ?></td>
                            <td><?= number_format($totalTuition, 2) ?></td>
                            <td>
                            </td>
                            <td>
                                <?php if (!empty($paymentProofStatus)) echo htmlspecialchars($paymentProofStatus); ?>
                            </td>
                        </tr>

                        <!-- Previous Payments Rows (from paymentHistory) -->
                        <?php if (!empty($paymentHistory)): ?>
                            <?php foreach ($paymentHistory as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['school_year']) ?></td>
                                    <td><?= htmlspecialchars($row['term']) ?></td>
                                    <td><?= htmlspecialchars($row['year_level'] ?? '') ?></td>
                                    <td></td>
                                    <td><?= htmlspecialchars($row['payment_description']) ?></td>
                                    <td><?= htmlspecialchars(date('m/d/Y', strtotime($row['upload_date']))) ?></td>
                                    <td><?= isset($row['amount']) ? number_format($row['amount'], 2) : '' ?></td>
                                    <td></td>
                                    <td>
                                        <?php 
                                            $rowStatus = strtolower($row['status']);
                                            $isReceived = ($rowStatus === 'received');
                                            $disableUpload = $isReceived;
                                            $inputId = 'tuition-due-upload-' . $row['id']; // unique ID per row
                                        ?>
                                        <input type="file" name="tuition_due_upload_<?= $row['id'] ?>" id="<?= $inputId ?>" accept=".jpg, .jpeg, .png, .pdf" style="display:none;" onchange="this.form.submit()" <?= $disableUpload ? 'disabled' : '' ?>>
                                        <label for="<?= $inputId ?>" class="<?= $isReceived ? 'received-file-upload__custom' : 'pending-file-upload__custom' ?>" style="cursor:pointer;<?= $disableUpload ? 'opacity:0.5;pointer-events:none;' : '' ?>">Upload</label>
                                    </td>
                                    <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </form>
        </div>
<?php
                // DEBUG: Show current term, school year, and registered subjects
                echo '<div style="background:#ffe;border:1px solid #cc0;padding:8px;margin-bottom:10px;">';
                echo '<strong>DEBUG:</strong><br>';
                echo 'Current School Year: ' . htmlspecialchars($currentSchoolYear) . '<br>';
                echo 'Current Term: ' . htmlspecialchars($currentTerm) . '<br>';
                echo 'Registered Subjects Count: ' . (is_array($registeredSubjects) ? count($registeredSubjects) : 0) . '<br>';
                echo 'Total Tuition: ' . htmlspecialchars($totalTuition) . '<br>';
                echo '</div>';
?>
    </div>
</body>
</html>