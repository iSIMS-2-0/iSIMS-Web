<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/ConcernsFeedback/concernsFeedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Concerns and Feedback</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <div class="container">
                <div class="titleAndLinks">
                    <h1>Concerns and Feedback</h1>
                    <div class="links">
                        <a href="https://forms.gle/L2NxAhRCpoMNjVEK6" target="contentFrame">Concerns</a>
                        <a href="https://forms.gle/5gu5BmwjdcC1TbfX7" target="contentFrame">Feedback</a>
                    </div>
                </div>
                <div class="gforms">
                    <iframe name="contentFrame"></iframe>
                </div>
            </div>
        </div>
    </div>
</body>
</html>