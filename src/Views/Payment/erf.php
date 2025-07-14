<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Payment/erf.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <script defer src="/public/assets/JavaScript/erfPopUp.js"></script>
    <title>ERF</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Electronic Registration Form
            <form method="get">
                <input type="hidden" name="page" value="erf">
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
                    <iframe src="/public/assets/pdfFile/erf.pdf#toolbar=0"></iframe>
                </div>
                <div class="paymentMethods">
                    <div class="paymentTitle">
                        <h5>Select Payment Methods</h5>
                    </div>
                    <div class="paymentButtons">
                            <a href="#" class="cardPayment" id="openBankPopup">
                                <i class="fa-solid fa-building-columns"></i></i> Online Bank Transfer
                            </a>

                            <a href="https://tinyurl.com/Card-Online-Payment" class="cardPayment">
                                <i class="fas fa-credit-card"></i> Credit Card Payment
                            </a>

                            <div class="note">
                                <p><strong>Note:</strong> upload proof of payment in <a href="onlinePayment.php">Online Payment</a> section.</p>
                            </div>
                    </div>
                </div>  
            </div>

            <!-- pop-up for bank details -->
            <div class="popUpContainer">
                <div class="bankDetails">
                    <div class="bankHeader">
                        <div class="closeBttn">&times;</div>
                        <div class="bankTitle"><h2>iACADEMY BANK DETAILS</h2></div>
                    </div>

                    <div class="bankInfo">
                        <div class="accName">
                            <h3>Account Name:</h3>
                            <p>iACADEMY INC.</p>
                        </div>
                        <div class="details">
                            <div class="bank">
                                <h4>ㅤ</h4>
                                <p>SECURITY BANK</p>
                                <p>METROBANK</p>
                            </div>
                            <div class="accountNum">
                                <h4>Account Number:</h4>
                                <p>0514 - 043205 - 001</p>
                                <p>291 - 7 - 29181232 - 1</p>
                            </div>
                            <div class="swiftCode">
                                <h4>Swift Code:</h4>
                                <p>SETCPHMM</p>
                                <p>MBTCPHMM</p>
                            </div>
                        </div>
                    </div>

                    <div class="bankInfo">
                        <div class="accName">
                            <h3>Account Name:</h3>
                            <p>INFORMATION & COMMUNICATIONS <br> TECHNOLOGY ACADEMY INC.</p>
                        </div>
                        <div class="details">
                            <div class="bank">
                                <h4>ㅤ</h4>
                                <p>BDO UNIBANK</p>
                                <p>CHINA BANK</p>
                            </div>
                            <div class="accountNum">
                                <h4>Account Number:</h4>
                                <p>0089 - 5800 - 5430</p>
                                <p>1003 - 0000 - 5963</p>
                            </div>
                            <div class="swiftCode">
                                <h4>Swift Code:</h4>
                                <p>SETCPHMM</p>
                                <p>MBTCPHMM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>