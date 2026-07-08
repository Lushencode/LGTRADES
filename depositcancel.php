<?php
session_start();

$_SESSION['error_msg'] = "Deposit was cancelled or failed.";

header("Location: dashboard.php");
exit();
?>