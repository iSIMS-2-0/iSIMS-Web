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
        <aside class="nav_bar" id="sidebar">
                <div class="nav_item">
                    <i class="fa-solid fa-house fa-lg"></i>
                    <p>HOME</p>
                </div>

                <div class="nav_item" onclick="toggleDropdown('profile')">
                    <i class="fa-solid fa-user fa-lg"></i>
                    <p>PROFILE</p>
                </div>
                <div id="profile" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>

                <div class="nav_item" onclick="toggleDropdown('enrollment')">
                    <i class="fa-solid fa-user fa-lg"></i>
                    <p>ENROLLMENT</p>
                </div>
                <div id="enrollment" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>

                <div class="nav_item" onclick="toggleDropdown('payment')">
                    <i class="fa-solid fa-user fa-lg"></i>
                    <p>PAYMENT</p>
                </div>
                <div id="payment" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>

                <div class="nav_item" onclick="toggleDropdown('concernsfeedback')">
                    <i class="fa-solid fa-user fa-lg"></i>
                    <p>CONCERNS/<br>FEEDBACK</p>
                </div>
                <div id="concernsfeedback" class="dropdown">
                    <a href="#"><p>Student Profile</p></a>
                    <a href="#"><p>Grades </p></a>
                    <a href="#"><p>Schedule</p></a>
                </div>
                <div class="logout_button">
                    <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                    <a href="#"><p>LOGOUT</p></a>
                </div>
        </aside>    

        <div class="contents">
            <div class="welcomeMessage">
                <p>Welcome, [First Name][Last Name]</p> <!-- di naka h kase para di naka bold, pero pwede rin h tas set lang font weight -->
            </div>
            <div class="schoolBulletin">
                <div class="announcements">
                    <h2>Announcements</h2>
                    <p>Lorem ipsum dolor sit amet.</p>
                </div>
                <div class="remarks">
                    <h2>Remarks</h2>
                    <p>Lorem ipsum dolor sit amet.</p>
                </div>
                <div class="calendar">
                    <h2>Calendar</h2>
                </div>
            </div>
        </div>
    </div>
</body>
<html>