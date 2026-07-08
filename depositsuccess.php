<?php
session_start();

$_SESSION['success_msg'] = "Deposit completed successfully.";

header("Location: dashboard.php");
exit();
?>