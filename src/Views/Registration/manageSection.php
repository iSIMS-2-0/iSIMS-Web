<?php
// Helper functions for presentation
function getYearLevelText($yearLevel) {
    $yearTexts = [
        1 => '1st Year',
        2 => '2nd Year', 
        3 => '3rd Year',
        4 => '4th Year'
    ];
    return $yearTexts[$yearLevel] ?? "{$yearLevel}th Year";
}

function getTermText($termNumber) {
    $termTexts = [
        1 => '1st Term',
        2 => '2nd Term',
        3 => '3rd Term'
    ];
    return $termTexts[$termNumber] ?? "{$termNumber}th Term";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Registration/manageSection.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Registration</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Registration</h1>
            <div class="myInfo">
                <div class="infoTitle">
                    <h2>My Information</h2>
                </div>
                <div class="infoContent">
                    <div class="infoCont1">
                        <div class="content">
                            <span class="infoLabel">Name: </span>
                            <span><?= htmlspecialchars($student['name'] ?? 'N/A') ?></span>
                        </div>
                        
                        <div class="content">
                            <span class="infoLabel">Program: </span>
                            <span><?= htmlspecialchars($programName ?? 'N/A') ?></span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Academic Year: </span>
                            <span><?= htmlspecialchars($currentSchoolYear ?? 'N/A') ?></span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Status: </span>
                            <span><?= htmlspecialchars($studentStatus ?? 'N/A') ?></span>
                        </div>
                    </div>
                    <div class="infoCont2">
                         <div class="content">
                            <span class="infoLabel">Student Number: </span>
                            <span><?= htmlspecialchars($student['student_number'] ?? 'N/A') ?></span>
                        </div>
                        
                        <div class="content">
                            <span class="infoLabel">Year Level: </span>
                            <span><?= htmlspecialchars(getYearLevelText($yearLevel ?? 1)) ?></span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Term: </span>
                            <span><?= htmlspecialchars(getTermText($currentTerm ?? 1)) ?></span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Section: </span>
                            <span><?= htmlspecialchars($sectionInfo ?? 'Not Assigned') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <h1>Registered Subjects</h1>
            <table class="registeredSubTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Code</th>
                        <th>Description</th>
                        <th>Lect Hours</th>
                        <th>Lab Hours</th>
                        <th>Credit Units</th>
                        <th>Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($registeredSubjects)): ?>
                        <?php foreach ($registeredSubjects as $index => $subject): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($subject['code']) ?></td>
                                <td><?= htmlspecialchars($subject['name']) ?></td>
                                <td>-</td> <!-- Lect Hours - not in current schema -->
                                <td>-</td> <!-- Lab Hours - not in current schema -->
                                <td><?= htmlspecialchars($subject['units']) ?></td>
                                <td><?= htmlspecialchars($subject['schedule'] ?? 'TBA') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Total Units Row -->
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td colspan="5" style="text-align: right;">Total Units:</td>
                            <td><?= htmlspecialchars($totalUnits ?? 0) ?></td>
                            <td>-</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #666; font-style: italic; padding: 20px;">
                                No subjects registered for the current term.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="button">
                <a href="/public/index.php?page=erf" class="viewBttn" style="text-decoration: none; display: inline-block; text-align: center;">VIEW ASSESSMENT</a>
            </div>
        </div>
    </div>
</body>
</html>