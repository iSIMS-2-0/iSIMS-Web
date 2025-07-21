<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Payment/paymentHistory.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Payment History</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Payment History</h1>

            <div class="student-information">
                <div class="student-name">
                    <h4>Student Name:</h4>
                    <p><?= htmlspecialchars($student['name'] ?? '') ?></p>
                </div>

                <div class="student-number">
                    <h4>Student Number:</h4>
                    <p><?= htmlspecialchars($student['student_number'] ?? '') ?></p>
                </div>
            </div>


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
                        <th>Payment</th>
                        <th>Balance</th>
                    </tr>
                </thead>

                <tbody class="payment-history-table__body">
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
                                <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align:center;">No payment history found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>


            </table>
        </div>
    </div>
</body>
</html>