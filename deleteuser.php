<?php
session_start();
include "db.php";

$username = $_GET['username'];

$sql = "DELETE FROM users WHERE username = '$username'";

mysqli_query($conn, $sql);

$_SESSION['success_msg'] = "User successfully deleted";
exit();

?>