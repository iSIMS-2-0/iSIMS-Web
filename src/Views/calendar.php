<!DOCTYPE html>
<html>
<body>
<?php
    date_default_timezone_set('Asia/Manila');

    $month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

    $events = [
        '01-01' => "New Year's Day",
        '02-25' => "EDSA People's Power Day",
        '04-09' => "Araw ng Kagitingan",
        '05-01' => "Labor Day",
        '06-12' => "Independence Day",
        '08-21' => "Ninoy Aquino Day",
        '08-26' => "National Heroes Day",
        '11-01' => "All Saints' Day",
        '11-30' => "Bonifacio Day",
        '12-08' => "Feast of Immaculate Conception",
        '12-25' => "Christmas Day",
        '12-30' => "Rizal Day",
        '12-31' => "New Year's Eve",
    ];

    $first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
    $total_days = date('t', $first_day_of_month);
    $start_day_index = date('N', $first_day_of_month); 

    $prev_month = $month - 1;
    $prev_year = $year;
    if ($prev_month < 1) {
        $prev_month = 12;
        $prev_year--;
    }

    $next_month = $month + 1;
    $next_year = $year;
    if ($next_month > 12) {
        $next_month = 1;
        $next_year++;
    }

    $last_day_prev_month = date('t', mktime(0, 0, 0, $prev_month, 1, $prev_year));
    $prev_days_count = $start_day_index - 1;

    $total_cells = $prev_days_count + $total_days;
    $next_days_count = (7 - ($total_cells % 7)) % 7;

    $month_name = date('F', $first_day_of_month);
?>
    <div class="calendar">
        <h2>Calendar</h2>
        <ul class="calendar-nav">
            <li class="prev">
                <a href="" data-month="<?php echo $prev_month; ?>" data-year="<?php echo $prev_year; ?>">&#10094;</a>
            </li>
            
            <li class="month-year">
                <?php echo $month_name . " " . $year; ?>
            </li>

            <li class="next">
                <a href="#" data-month="<?php echo $next_month; ?>" data-year="<?php echo $next_year; ?>">&#10095;</a>
            </li>
        </ul>
    </div>
    <ul class="days">
        <li>Mon</li>
        <li>Tue</li>
        <li>Wed</li>
        <li>Thu</li>
        <li>Fri</li>
        <li>Sat</li>
        <li>Sun</li>
    </ul>
    <ul class="weekdays">
        <?php
            for ($i = $prev_days_count; $i > 0; $i--) {
                $day = $last_day_prev_month - $i + 1;
                echo "<li><span class='inactive'>$day</span></li>";
            }

            for ($day = 1; $day <= $total_days; $day++) {
                $month_day = sprintf('%02d-%02d', $month, $day);
                $day_of_week = date('N', mktime(0, 0, 0, $month, $day, $year));

                $classes = "";
                if ($day_of_week == 6) {
                    $classes = "saturday";
                } elseif ($day_of_week == 7) {
                    $classes = "sunday";
                }

                $today = date('Y-m-d');
                $current_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                if ($today === $current_date) {
                    $classes .= " today"; 
                }
                
                echo "<li>";
                if (array_key_exists($month_day, $events)) {
                    echo "<span class='events $classes'>$day</span>";
                    echo "<div class='hide'>" . $events[$month_day] . "</div>";
                } else {
                    echo "<span class='$classes'>$day</span>";
                }
                echo "</li>";
            }

            for ($i = 1; $i <= $next_days_count; $i++) {
                echo "<li><span class='inactive'>$i</span></li>";
            }
        ?>
    </ul>
</body>
</html>