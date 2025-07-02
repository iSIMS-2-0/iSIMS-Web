<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Payment/erf.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>ERF</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Electronic Registration Form
            <form method="get">
                <div class="selection">
                    <div class="syDiv">
                        <label for="schoolYear">School Year:</label>  
                        <select name="schoolYear" id="schoolYear" onchange="this.form.submit()">
                            <option value="<?= htmlspecialchars($selected_sy) ?>"><?= htmlspecialchars($selected_sy) ?></option>
                        </select>
                    </div>
                
                    <div class="termDiv">
                        <label for="term">Term:</label>
                        <select name="term" id="term" onchange="this.form.submit()">
                            <option value="1st Term"<?= $selected_term=='1st Term'?' selected':''; ?>>1st Term</option>
                            <option value="2nd Term"<?= $selected_term=='2nd Term'?' selected':''; ?>>2nd Term</option>
                            <option value="3rd Term"<?= $selected_term=='3rd Term'?' selected':''; ?>>3rd Term</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="erfAndTable">
                <div class="erfFrame">
                    .
                </div>
                <div class="paymentMethods">
                    <div class="paymentTitle">
                        <h5>Select Payment Methods</h5>
                    </div>
                    <div class="paymentButtons">
                            <a href="https://tinyurl.com/Card-Online-Payment" class="cardPayment">
                                <i class="fa-solid fa-building-columns"></i></i> Online Bank Transfer
                            </a>

                            <a href="https://tinyurl.com/Card-Online-Payment" class="cardPayment">
                                <i class="fas fa-credit-card"></i> Credit Card Payment
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>