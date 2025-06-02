<?php
$subjectGrade = array(
    array(
        'subject_code' => 'CS101',
        'subject_name' => 'Computer Science 101',
        'section' => 'A',
        'units' => 3,
        'grade' => 1.25
    ),
    array(
        'subject_code' => 'COMPARCH',
        'subject_name' => 'Computer Architecture',
        'section' => 'SEG21',
        'units' => 3,
        'grade' => 0.00
    )
);

    function gradeDisplay($subjectGrades){
    foreach ($subjectGrades as $subjectGrade) {
        echo "<tr>
            <td>{$subjectGrade['subject_code']}</td>
            <td>{$subjectGrade['subject_name']}</td>
            <td>{$subjectGrade['section']}</td>
            <td>{$subjectGrade['units']}</td>
            <td>" . number_format($subjectGrade['grade'], 2) . "</td>
        </tr>";
    }
}
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
        <form>  
            <div class="selection">
            <div class="syDiv">
                    <label for="schoolYear">School Year:</label>
                    <select name="schoolYear" id="schoolYear">
                        <option value="1st">2024-2025</option>
                    </select>
            </div>

                <div class="termDiv">
                    <label for="term">Term:</label>
                    <select name="term" id="term">
                        <option value="1st">1st Term</option>
                        <option value="2nd">2nd Term</option>
                        <option value="3rd">3rd Term</option>
                    </select>
                </div>
            </div>
        </form>
        <table>
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
                <?php gradeDisplay($subjectGrade); ?>
            </tbody>
        </table>
     </div>
   </div>
</body>
</html>