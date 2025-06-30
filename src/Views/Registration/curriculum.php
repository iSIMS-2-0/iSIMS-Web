<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Registration/curriculum.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Curriculum</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <h1>Curriculum</h1>

            <form method="get">
                <div class="selection">
                    <div class="school-year">
                        <label for="school-year">School Year:</label>
                        <select name="school-year" id="school-year__select">
                            <option value="" selected hidden>Select School Year</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>

                    <div class="year-term">
                        <label for="year-term">Term:</label>
                        <select name="year-term" id="year-term__select">
                            <option value="" selected hidden>Select Term</option>
                            <option value="1st term">1st Term</option>
                            <option value="2nd term">2nd Term</option>
                            <option value="3rd term">3rd Term</option>
                        </select>
                    </div>
                </div>
            </form>

           
            <div class="tables">
                <table class="curriculum-table">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Description</th>
                            <th>Pre-requisite</th>
                            <th>Units</th>
                        </tr>
                    </thead>

                    <tbody class="curriculum-table__body">
                        <td>CSELEC03</td>
                        <td>Fundamentals of Web Programming</td>
                        <td></td>
                        <td>3.0</td>
                    </tbody>

                    <tbody class="curriculum-table__body">
                        <td>CSELEC04</td>
                        <td>Unified Modelling Language</td>
                        <td></td>
                        <td>3.0</td>
                    </tbody>

                    <tbody class="curriculum-table__body">
                        <td>FILIPIN2</td>
                        <td>Filipino sa Iba't Ibang Disiplina</td>
                        <td></td>
                        <td>3.0</td>
                    </tbody>

                    <tbody class="curriculum-table__body">
                        <td>RIZALIFE</td>
                        <td>Rizal's Life, Works, and Writings</td>
                        <td></td>
                        <td>3.0</td>
                    </tbody>

                    <tbody class="curriculum-table__body">
                        <td>SOFTENG1</td>
                        <td>Software Engineering 1</td>
                        <td></td>
                        <td>3.0</td>
                    </tbody>

                    <tbody class="curriculum-table__body">
                        <td>CSELEC02</td>
                        <td>Core Java Programming 2</td>
                        <td></td>
                        <td>3.0</td>
                    </tbody>
                </table>

                <table class="legend-table">
                    <thead>
                        <tr>
                            <th colspan="2">Legend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="box-color passed"></td>
                            <td>Already Passed</td>
                        </tr>

                        <tr>
                            <td class="box-color not-taken"></td>
                            <td>Not Yet Taken</td>
                        </tr>

                        <tr>
                            <td class="box-color enrolled"></td>
                            <td>Currently Enrolled</td>
                        </tr>
                        
                        <tr>
                            <td class="box-color failed"></td>
                            <td>Failed</td>
                        </tr>
                    </tbody>

                 </table>
            </div>
        </div>
    </div>
</body>
</html>