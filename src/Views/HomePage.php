<?php
session_start();
//Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: /public/index.php?message=Please log in to access this page.");
//     exit();
// }

// // Check for session timeout
// if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) { // 600 seconds = 10 minutes
//     // Session has expired
//     session_unset();
//     session_destroy();
//     header("Location: /public/index.php?message=Session expired. Please log in again.");
//     exit();
// }
// // Update last activity time
// $_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Homepage/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Home</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <main class="mainContainer">
        <div class="contents">
            <div class="welcomeMessage">
                <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
            </div>

            <div class="schoolBulletin">
                <div class="announcements">
                    <h2>Announcements</h2>
                    <div class="announcement">
                        <h4>STEVAL FOR TERM 3</h4>
                        <p>It's time for Term 3’s Student Evaluation of Teaching (STEVAL). Your feedback is invaluable to us as we strive to improve your learning experience. Please take a few moments to complete the STEVAL form. Please note that we now have one form for each of your teachers. Forms will be available until JULY 31 5:00 PM ONLY</p>
                    </div>

                    <div class="announcement">
                        <h4>REPLACEMENT OF 10TH FLOOR MONITORS</h4>
                        <p>We would like to inform you that some of the monitors on the 10th floor have been found to be not in a best condition. While we await the arrival of new replacement units, we have installed service monitors to ensure minimal disruption to your work and classes.</p>
                    </div>

                </div>

                <div class="remarks">
                    <h2>Remarks</h2>
                    <div class="remark">
                        <h4>DEFICIENCY</h4>
                        <p>Your enrollment is currently on hold due to a missing document. Please upload your proof of payment to complete your enrollment and become officially enrolled.</p>
                    </div>


                </div>

                <div class="calendar">
                    <h2>Calendar</h2>
                </div>
            </div>
        </div>
    </main>
</body>
</html>