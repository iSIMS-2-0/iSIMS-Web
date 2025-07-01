<aside id="sidebar" class="sidebar">
    <div class="navList">
        <a href="/src/Views/HomePage.php" class="navItem">
            <i class="fa-solid fa-house fa-lg"></i>
            <p>HOME</p>
        </a>

        <!-- PROFILE -->
        <div class="navItem" onclick="toggleDropdown('profile', this)">
            <i class="fa-solid fa-user fa-lg"></i>
            <p>PROFILE</p>
            <div class="arrowIcon">
                <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
            </div>
        </div>
        <div id="profile" class="dropdown">
            <a href="/src/Views/Profile/StudentProfile.php"><p>Student Profile</p></a>
            <a href="/src/Views/Profile//Grades.php"><p>Grades </p></a>
            <a href="/src/Views//Profile//Schedule.php"><p>Schedule</p></a>
        </div>

        <!-- REGISTRATION -->
        <div class="navItem" onclick="toggleDropdown('registration', this)">
            <i class="fa-solid fa-file-invoice fa-lg"></i>
            <p>REGISTRATION</p>
            <div class="arrowIcon">
                <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
            </div>
        </div>
        <div id="registration" class="dropdown">
            <a href="/src/Views/Registration/curriculum.php"><p>Curriculum</p></a>
            <a href="/src/Views/Registration/manageSection.php"><p>Manage Section</p></a>
        </div>

        <!-- PAYMENT -->
        <div class="navItem" onclick="toggleDropdown('payment', this)">
            <i class="fa-solid fa-credit-card fa-lg"></i>
            <p>PAYMENT</p>
            <div class="arrowIcon">
                <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
            </div>
        </div>
        <div id="payment" class="dropdown">
            <a href="#"><p>Electronic Registration Form</p></a>
            <a href="#"><p>Online payment</p></a>
            <a href="#"><p>Payment History</p></a>
        </div>
                
        <!-- CONCERNS/FEEDBACK -->
        <div class="navItem">
            <i class="fa-solid fa-circle-exclamation fa-lg"></i>
            <p>CONCERNS/<br>FEEDBACK</p>
        </div>
    </div>

    <div class="navLogout">
        <a href="/public/logout.php">
        <i class="fa-solid fa-right-from-bracket fa-lg"></i>
        <p>LOGOUT</p>
        </a>
    </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/loadingOverlay.php"; ?>
</aside>