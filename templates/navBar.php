<aside id="navBar" class="navBar">
    <div class="navList">
        <div class="navItem">
            <i class="fa-solid fa-house fa-lg"></i>
            <p>HOME</p>
        </div>

        <div class="navItem" onclick="toggleDropdown('profile')">
            <i class="fa-solid fa-user fa-lg"></i>
            <p>PROFILE</p>
            <div class="arrowIcon">
                <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
            </div>
        </div>
        <div id="profile" class="dropdown">
            <a href="#"><p>| Student Profile</p></a>
            <a href="#"><p>| Grades </p></a>
            <a href="#"><p>| Class Schedule</p></a>
        </div>

        <div class="navItem" onclick="toggleDropdown('registration')">
            <i class="fa-solid fa-file-invoice fa-lg"></i>
            <p>REGISTRATION</p>
            <div class="arrowIcon">
                <i class="fa-solid fa-caret-right fa-lg dropdown"></i>
            </div>
        </div>
        <div id="registration" class="dropdown">
            <a href="#"><p>| Curriculum</p></a>
            <a href="#"><p>| Manage Section</p></a>
        </div>

        <div class="navItem" onclick="toggleDropdown('payment')">
            <i class="fa-solid fa-credit-card fa-lg"></i>
            <p>PAYMENT</p>
            <div class="arrowIcon">
                <i class="fa-solid fa-caret-right fa-lg"></i>
            </div>
        </div>
        <div id="payment" class="dropdown">
            <a href="#"><p>| Electronic Registration Form</p></a>
            <a href="#"><p>| Online payment</p></a>
            <a href="#"><p>| Payment History</p></a>
        </div>
        
        <div class="navItem">
            <i class="fa-solid fa-circle-exclamation fa-lg"></i>
            <p>CONCERNS/<br>FEEDBACK</p>
        </div>
    </div>

    <div class="navLogout">
        <i class="fa-solid fa-right-from-bracket fa-lg"></i>
        <p>LOGOUT</p>
    </div>
</aside>