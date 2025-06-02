<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/grades.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Grades</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

   <div class="mainContainer">
     <div class="contents">
        <h1>Student Grades</h1>
        <table class="gradesTable">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>SUBJECT NAME</th>
                <th>SECTION</th>
                <th>UNITS</th>
                <th>GRADE</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
     </div>
   </div>
</body>
</html>