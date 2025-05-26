<?php
session_start();
sleep(1); // Add a 1-second delay
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: /public/index.php"); // Redirect to the login page
exit();
?>