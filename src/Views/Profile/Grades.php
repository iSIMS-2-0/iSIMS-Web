<?php   
    require_once $_SERVER["DOCUMENT_ROOT"] . "/src/Helpers/GradeHelpers.php";
?>
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
            <form method="get">  
                <div class="selection">
                    <div class="syDiv">
                        <label for="schoolYear">School Year:</label>
                        <select name="schoolYear" id="schoolYear" onchange="this.form.submit()">
                            <option value="<?= htmlspecialchars($selected_sy) ?>"><?= htmlspecialchars($selected_sy) ?></option>
                        </select>
                    </div>
                        <form method="get">
                        <input type="hidden" name="page" value="grades">
                        <div class="termDiv">
                            <label for="term">Term:</label>
                            <select name="term" id="term" onchange="this.form.submit()">
                                <option value="1st Term"<?= $selected_term=='1st Term'?' selected':''; ?>>1st Term</option>
                                <option value="2nd Term"<?= $selected_term=='2nd Term'?' selected':''; ?>>2nd Term</option>
                                <option value="3rd Term"<?= $selected_term=='3rd Term'?' selected':''; ?>>3rd Term</option>
                            </select>
                        </div>
                    </form>
                </div>
            </form>
            <table class = "gradesTable">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Section</th>
                        <th>Units</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php gradeDisplay($studentGrades); ?>
                </tbody>
            </table>
            <table class = "gradeSummary">
                <tr>
                    <th>PROGRAM</th>
                    <td><?= htmlspecialchars($program) ?></td>
                </tr>
                <tr>
                    <th>GWA</th>
                    <td><?php calculateGwa($studentGrades); ?></td>
                </tr>
                <tr>
                    <th>ENROLLMENT STATUS</th>
                    <td>Continuing</td> <!--place holder only, should b server sided-->
                </tr>
            </table>
        </div>
   </div>
</body>
</html>