<aside class="nav_bar" id="sidebar">
    <div class="nav_item">
        <i class="fa-solid fa-house fa-lg"></i>
        <h4>HOME</h4>
    </div>

    <div class="nav_item" onclick="toggleDropdown('profile')">
        <i class="fa-solid fa-user fa-lg"></i>
        <h4>PROFILE</h4>
    </div>
    <div id="profile" class="dropdown">
        <a href="#"><p>Student Profile</p></a>
        <a href="#"><p>Grades </p></a>
        <a href="#"><p>Schedule</p></a>
    </div>

    <div class="nav_item" onclick="toggleDropdown('enrollment')">
        <i class="fa-solid fa-user fa-lg"></i>
        <h4>REGISTRATION</h4>
    </div>
    <div id="enrollment" class="dropdown">
        <a href="#"><p>Curriculum</p></a>
        <a href="#"><p>Manage Subject</p></a>
    </div>

    <div class="nav_item" onclick="toggleDropdown('payment')">
        <i class="fa-solid fa-user fa-lg"></i>
        <h4>BILLS &<br>PAYMENT</h4>
    </div>
    <div id="payment" class="dropdown">
        <a href="#"><p>| Electronic Registration Form</p></a>
        <a href="#"><p>| Online Payment</p></a>
        <a href="#"><p>| Payment History</p></a>
    </div>

    <div class="nav_item" onclick="toggleDropdown('concernsfeedback')">
        <i class="fa-solid fa-user fa-lg"></i>
        <h4>CONCERNS/<br>FEEDBACK</h4>
    </div>
    <div id="concernsfeedback" class="dropdown">
        <a href="#"><p>| Student Profile</p></a>
        <a href="#"><p>Grades </p></a>
        <a href="#"><p>Schedule</p></a>
    </div>
    <div class="logout_button">
        <i class="fa-solid fa-right-from-bracket fa-lg"></i>
        <a href="#"><p>LOGOUT</p></a>
    </div>
</aside> 