<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/schedule.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Grades</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

   <div class="mainContainer">
     <div class="contents">
        <h1>Schedule</h1>
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
        <div class="scheduleTable">
            <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>7:30-11:00</td>
                        <td></td>
                        <td>COMPARCH<br>SEG21<br>911-N</td>
                        <td></td>
                        <td>CSELEC01<br>SEG21<br>1005-N</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                     <tr>
                        <td>11:00-2:30</td>
                        <td></td>
                        <td>CSELEC07<br>SEG21<br>1006-N</td>
                        <td></td>
                        <td></td>
                        <td>CSELEC04<br>SEG21<br>809-N</td>
                        <td>FUNPROG<br>SEG21<br>1002-N</td>
                        <td></td>
                    </tr>
                     <tr>
                        <td>2:30-6:00</td>
                        <td></td>
                        <td>INFOMAN<br>SEG21<br>1005-N</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PATHFIT<br>SEG21<br>1100-N</td>
                        <td></td>
                    </tr>
            </tbody>
        </table>
        </div>
     </div>
   </div>
</body>
</html>