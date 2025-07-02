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
                    <p>Last Name, First Name</p>
                </div>

                <div class="student-number">
                    <h4>Student Number:</h4>
                    <p>Student Number</p>
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
                    <tr>
                        <td>2024 - 2025</td>
                        <td>2nd</td>
                        <td>2</td>
                        <td></td>
                        <td>MATRICULATION FEE</td>
                        <td>12/17/2024</td>
                        <td>85932.00</td>
                        <td>85932.00</td>
                        <td>0.00</td>
                    </tr>
                </tbody>

                <tbody class="payment-history-table__body">
                    <tr>
                        <td>2024 - 2025</td>
                        <td>2nd</td>
                        <td>2</td>
                        <td></td>
                        <td>MATRICULATION FEE</td>
                        <td>12/17/2024</td>
                        <td>85932.00</td>
                        <td>85932.00</td>
                        <td>0.00</td>
                    </tr>
                </tbody>


            </table>
        </div>
    </div>
</body>
</html>