<?php
session_start();
require 'config.php';

// Destroy session and remove cookie
setcookie("rememberMeToken", "", time() - 3600, "/"); // Expire the cookie
session_destroy();

header("Location: login.html"); // Redirect to login
exit;
?>
