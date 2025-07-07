<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Homepage/homepage.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Homepage/calendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Home</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <main class="mainContainer">
        <div class="contents">
            <div class="welcomeMessage">
                <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
            </div>

            <div class="schoolBulletin">
                <div class="announcements">
                    <h2>Announcements</h2>
                    <div class="announcement">
                        <h4>STEVAL FOR TERM 3</h4>
                        <p>It's time for Term 3’s Student Evaluation of Teaching (STEVAL). Your feedback is invaluable to us as we strive to improve your learning experience. Please take a few moments to complete the STEVAL form. Please note that we now have one form for each of your teachers. Forms will be available until JULY 31 5:00 PM ONLY</p>
                    </div>

                    <div class="announcement">
                        <h4>REPLACEMENT OF 10TH FLOOR MONITORS</h4>
                        <p>We would like to inform you that some of the monitors on the 10th floor have been found to be not in a best condition. While we await the arrival of new replacement units, we have installed service monitors to ensure minimal disruption to your work and classes.</p>
                    </div>

                </div>

                <div class="remarks">
                    <h2>Remarks</h2>
                    <div class="remark">
                        <h4>DEFICIENCY</h4>
                        <p>Your enrollment is currently on hold due to a missing document. Please upload your proof of payment to complete your enrollment and become officially enrolled.</p>
                    </div>


                </div>

                <div class="calendarCont">
                    <h2>Calendar</h2>
                    <div class ="calendar">
                        <ul>
                            <li class="prev">&#10094;</li>
                            <li class="next">&#10095;</li>
                            <li style="text-align: left; padding-left: 30px;">
                            June <br> 2025
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
                            <li><span class="inactive">26</span></li>
                            <li><span class="inactive">27</span></li>
                            <li><span class="inactive">28</span></li>
                            <li><span class="inactive">29</span></li>
                            <li><span class="inactive">30</span></li>
                            <li><span class="inactive">31</span></li>
                            <li><span class="weekends">1</span></li>
                            <li><span class="weekends">2</span></li>
                            <li>3</li>
                            <li>4</li>
                            <li>5</li>
                            <li><span class="events">6</span>
                            <div class="hide">Eid'l Adha</div></li>
                            <li>7</li>
                            <li><span class="weekends">8</span></li>
                            <li><span class="events">9</span>
                            <div class="hide">Midterm Week</div></li>
                            <li><span class="events">10</span>
                            <div class="hide">Midterm Week</div></li>
                            <li><span class="events">11</span>
                            <div class="hide">Midterm Week</div></li>
                            <li><span class="events">12</span>
                            <div class="hide">Independence Day</div></li>
                            <li><span class="events">13</span>
                            <div class="hide">Midterm Week</div></li>
                            <li><span class="events">14</span>
                            <div class="hide">Midterm Week</div></li>
                            <li><span class="weekends">15</span></li>
                            <li><span class="weekends">16</span></li>
                            <li>17</li>
                            <li>18</li>
                            <li>19</li>
                            <li>20</li>
                            <li>21</li>
                            <li><span class="weekends">22</span></li>
                            <li><span class="events">23</span>
                            <div class="hide">School of Computing Week</div></li>
                            <li><span class="events">24</span>
                            <div class="hide">School of Computing Week</div></li>
                            <li><span class="events">25</span>
                            <div class="hide">School of Computing Week</div></li>
                            <li><span class="events">26</span>
                            <div class="hide">School of Computing Week</div></li>
                            <li><span class="events">27</span>
                            <div class="hide">School of Computing Week</div></li>
                            <li><span class="events">28</span>
                            <div class="hide">School of Computing Week</div></li>
                            <li><span class="weekends">29</span></li>
                            <li><span class="weekends">30</span></li>
                            <li><span class="inactive">1</span></li>
                            <li><span class="inactive">2</span></li>
                            <li><span class="inactive">3</span></li>
                            <li><span class="inactive">4</span></li>
                            <li><span class="inactive">5</span></li>
                            <li><span class="inactive">6</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>