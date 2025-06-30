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
                            <span>Student Name</span>
                        </div>
                        
                        <div class="content">
                            <span class="infoLabel">Program: </span>
                            <span>Student Program</span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Academic Year: </span>
                            <span>2024-2025</span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Status: </span>
                            <span>Status</span>
                        </div>
                    </div>
                    <div class="infoCont2">
                         <div class="content">
                            <span class="infoLabel">Student Number: </span>
                            <span>202400000</span>
                        </div>
                        
                        <div class="content">
                            <span class="infoLabel">Year Level: </span>
                            <span>Student Program</span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Semester: </span>
                            <span>3rd Semester</span>
                        </div>

                        <div class="content">
                            <span class="infoLabel">Section: </span>
                            <span>Section</span>
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
                        <td>1</td>
                        <td>CSELEC05</td>
                        <td>Enterprise Java 1</td>
                        <td>2</td>
                        <td>1</td>
                        <td>3.0</td>
                        <td>S 07:30 AM - 11:00 AM 1006-N</td>
                </tbody>
                <tbody>
                        <td>2</td>
                        <td>SOFTENG2</td>
                        <td>Software Engineering 2</td>
                        <td>3</td>
                        <td>0</td>
                        <td>3.0</td>
                        <td>T 07:30 AM - 11:00 AM 9011-N</td>
                </tbody>
            </table>

            <div class="button">
                <button class="viewBttn">VIEW ASSESSMENT</button>
            </div>
        </div>
    </div>
</body>
</html>