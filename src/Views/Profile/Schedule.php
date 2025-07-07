<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/schedule.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Schedule</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

   <div class="mainContainer">
     <div class="contents">
        <h1>Schedule</h1>
        <form method="get">
            <input type="hidden" name="page" value="schedule">
            <div class="selection">
                <div class="syDiv">
                    <label for="schoolYear">School Year:</label>  
                    <select name="schoolYear" id="schoolYear" onchange="this.form.submit()">
                        <option value="<?= htmlspecialchars($selected_sy ?? '') ?>"><?= htmlspecialchars($selected_sy ?? 'Current Year') ?></option>
                    </select>
                </div>
                <div class="termDiv">
                    <label for="term">Term:</label>
                    <select name="term" id="term" onchange="this.form.submit()">
                        <option value="1st Term"<?= ($selected_term ?? '')=='1st Term'?' selected':''; ?>>1st Term</option>
                        <option value="2nd Term"<?= ($selected_term ?? '')=='2nd Term'?' selected':''; ?>>2nd Term</option>
                        <option value="3rd Term"<?= ($selected_term ?? '')=='3rd Term'?' selected':''; ?>>3rd Term</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="scheduleTable">
        <table>
            <thead>
                <tr>
                    <th>Schedule</th>
                    <?php if (isset($days)): ?>
                        <?php foreach ($days as $day): ?>
                            <th><?= htmlspecialchars($day) ?></th>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <th>No schedule available</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($time_blocks) && isset($display_blocks) && isset($days) && isset($scheduleTable)): ?>
                    <?php foreach ($time_blocks as $i => $block): $blockKey = $block[0].'-'.$block[1]; ?>
                    <tr>
                        <td><?= htmlspecialchars($display_blocks[$i][0] . '-' . $display_blocks[$i][1]) ?></td>
                        <?php foreach ($days as $day): ?>
                            <td>
                                <?php 
                                if (!empty($scheduleTable[$blockKey][$day])) {
                                    echo implode('<hr>', $scheduleTable[$blockKey][$day]); 
                                } else {
                                    echo '<div class="emptyCellPlaceholder"></div>';
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No schedule data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
     </div>
   </div>
</body>
</html>