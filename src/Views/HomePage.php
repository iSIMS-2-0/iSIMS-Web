<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <div class="mainContainer">
        <div class="navBar"> 
            <ul class="navBar__list">
                <h3><li class="navbar__item"> <a href="#">PROFILE</a></li></h3>
                <h3><li class="navbar__item"> <a href="#">REGISTRATION</a></li>
                <h3><li class="navbar__item"> <a href="#">CURRICULUM</a></li>
                <h3><li class="navbar__item"> <a href="#">SCHEDULE</a></li>
                <h3><li class="navbar__item"> <a href="#">GRADES</a></li>
                <h3><li class="navbar__item"> <a href="#">ELECTRONIC REGISTRATION FORM</a></li>
                <h3><li class="navbar__item"> <a href="#">ONLINE PAYMENT</a></li>
                <h3><li class="navbar__item"> <a href="#">PAYMENT HISTORY</a></li>
                <h3><li class="navbar__item"> <a href="#">CONCERNS AND FEEDBACK</a></li>
            </ul>
            <div class="logout_button">
                <a href="#" class="navbar__logout">LOGOUT</a>
            </div>
        </div>
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