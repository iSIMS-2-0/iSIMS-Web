<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/base.css">
    <link rel="stylesheet" href="/public/assets/CSS/header.css">
    <link rel="stylesheet" href="/public/assets/CSS/homepage.css">
    <title>Document</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <div class="mainContainer">
        <div class="navBar"> 
            <!--Thinking na each section title, may sariling div kase may icon pa, instead na patong patong lang na text href -->
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