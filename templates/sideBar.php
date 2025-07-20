<aside id="sidebar" class="sidebar">
    <div class="navList">
        <a href="/public/index.php?page=home" class="navItem">
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
            <a href="/public/index.php?page=student_profile"><p>Student Profile</p></a>
            <a href="/public/index.php?page=grades"><p>Grades </p></a>
            <a href="/public/index.php?page=schedule"><p>Schedule</p></a>
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
            <a href="/public/index.php?page=curriculum"><p>Curriculum</p></a>
            <a href="/public/index.php?page=manage_section"><p>Manage Section</p></a>
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
            <a href="/public/index.php?page=erf"><p>Electronic Registration Form</p></a>
            <a href="/public/index.php?page=onlinepayment"><p>Online payment</p></a>
            <a href="/public/index.php?page=paymenthistory"><p>Payment History</p></a>
        </div>
                
        <!-- CONCERNS/FEEDBACK -->
        <div class="navItem">
            <i class="fa-solid fa-circle-exclamation fa-lg"></i>
            <a href="/public/index.php?page=concerns"><p>CONCERNS<br>FEEDBACK</p>
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