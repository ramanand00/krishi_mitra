<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy session

header("Location: login.html"); // Redirect to login page
exit();
?>
