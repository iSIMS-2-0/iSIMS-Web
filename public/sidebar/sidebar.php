<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Document</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <div class="mainContainer">
        <aside id="sidebar" class="sidebar">
            <div class="navList">
                <div class="navItem">
                    <i class="fa-solid fa-house fa-lg"></i>
                    <p>HOME</p>
                </div>

                <div class="navItem" onclick="toggleDropdown('profile')">
                    <i class="fa-solid fa-user fa-lg"></i>
                    <p>PROFILE</p>
                    <div class="arrowIcon">
                        <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
                    </div>
                </div>
                <div id="profile" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>

                <div class="navItem" onclick="toggleDropdown('registration')">
                    <i class="fa-solid fa-house fa-lg"></i>
                    <p>REGISTRATION</p>
                    <div class="arrowIcon">
                        <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
                    </div>
                </div>
                <div id="registration" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>

                <div class="navItem" onclick="toggleDropdown('registration')">
                    <i class="fa-solid fa-credit-card fa-lg"></i>
                    <p>PAYMENT</p>
                    <div class="arrowIcon">
                        <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
                    </div>
                </div>
                <div id="payment" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>
                
                <div class="navItem">
                    <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                    <p>CONCERNS/<br>FEEDBACK</p>
                </div>
            </div>

            <div class="navLogout">
                <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                <p>LOGOUT</p>
            </div>
        </aside>
    </div>
</body>
</html>