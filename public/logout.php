<?php
require_once __DIR__ . '/../src/Services/AuthService.php';

sleep(1); // Add a 1-second delay
AuthService::logout();
header("Location: /public/index.php?page=login"); // Redirect to the login page
exit();
?>