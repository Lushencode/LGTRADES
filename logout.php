<?php
session_start();

session_destroy(); // removes all session data

header("Location: home.php"); // send user back to login page
exit();
?>