<?php

session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users 
            WHERE (username='$username' OR email='$username') 
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        

        $row = mysqli_fetch_assoc($result);
        

        $_SESSION['username'] = $row['username'];
        $_SESSION['admin'] = $row['admin'];
       
        
        if(isset($_SESSION['redirect_url'])){
    $redirect = $_SESSION['redirect_url'];
    unset($_SESSION['redirect_url']);
    header("Location: $redirect");
}else if($_SESSION['admin'] == 1) {

           
            header("Location: admindashboard.php");
            exit();
        } else if($_SESSION["admin"] == 0) {
           header("Location:dashboard.php") ;

        }}
        else{
            $_SESSION['login_error'] = "Incorrect username/email or password";
            header("Location:auth.php");
        } 
        exit();
    }
?>
