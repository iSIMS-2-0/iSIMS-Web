<?php
//session_start();
// Check if the user is logged in
/*if (!isset($_SESSION['user_id'])) {
    header("Location: /public/index.php?message=Please log in to access this page.");
    exit();
}

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) { // 600 seconds = 10 minutes
    // Session has expired
    session_unset();
    session_destroy();
    header("Location: /public/index.php?message=Session expired. Please log in again.");
    exit();
}
// Update last activity time
$_SESSION['last_activity'] = time();*/
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
                    <h1>Announcements</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reprehenderit, harum. Numquam cupiditate ipsum, quae minima autem amet rem perspiciatis veritatis natus aspernatur doloribus magni. Ex sed dicta laboriosam magni maxime?</p>
                </div>

                <div class="remarks">
                    <h1>Remarks</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus officiis quam in nulla debitis aliquid! Veniam cumque rerum quo nobis reprehenderit laudantium explicabo. Dignissimos iure nam fugiat suscipit a exercitationem?</p>
                </div>

                <div class="calendar">
                    <h1>Calendar</h1>
                </div>
            </div>
        </div>
    </main>
</body>
</html>