<?php
session_start();
include("header.php");
if(isset($_SESSION['login_error'])){
    echo "<div class='error-msg'>".$_SESSION['login_error']."</div>";
    unset($_SESSION['login_error']);}

if(isset($_SESSION['success_msg'])){
    echo "<div class='success-msg'>".$_SESSION['success_msg']."</div>";
    unset($_SESSION['success_msg']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login / Register</title>
    <link rel="stylesheet" href="style.css">

</head>

<body class ="addproduct_body">
<div class="auth_wrap">
<div class="auth_card">

    <!-- TABS -->
    <div class="auth_tabs">
        <button class="active" onclick="showLogin()">Login</button>
        <button onclick="showRegister()">Register</button>
    </div>

    <!-- LOGIN FORM -->
    <form class="auth_form active" id="loginForm" action="login.php" method="POST">

        <input class = "auth_input" type="text" name="username" placeholder="Username\Email">
        <input class = "auth_input" type="password" name="password" placeholder="Password">

        <button class="auth_submit" type="submit">Login</button>

    </form>

    <!-- REGISTER FORM -->
    <form class="auth_form" id="registerForm" action="register.php" method="POST">

        <input class = "auth_input" type="text" maxlength="5" minlength="5" pattern="[A-Za-z0-9]{5}" title="Username must be exactly 5 letters or numbers" name="username" placeholder="Username">
        <input class = "auth_input" type="text" name="name" placeholder="Name">
        <input class = "auth_input" type="text" name="surname" placeholder="Surname">
        <input class = "auth_input" type="email" name="email" placeholder="Email">
        <input class = "auth_input" type="text" maxlength="10" minlength="10" pattern="[0-9]{10}" title="Please add a valid phone number (do not start with +27)" name="phone_number" placeholder="Phone Number">
        <input class = "auth_input" type="password" name="password" placeholder="Password">
        <input class = "auth_input" type="password" name="confirm_password" placeholder="Confirm Password">
        <input class = "auth_input" type="text" name="street_address" placeholder="Street Address">        
        <input class = "auth_input" type="text" name="city" placeholder="City">
        <input class = "auth_input" type="text" name="province" placeholder="Province">
        <input class = "auth_input" type="text" name="postal_code" placeholder="Postal Code">
        <button class="auth_submit" type="submit">Register</button>

    </form>

</div>

<script>
function showLogin() {
    document.getElementById("loginForm").classList.add("active");
    document.getElementById("registerForm").classList.remove("active");

    document.querySelectorAll(".auth_tabs button")[0].classList.add("active");
    document.querySelectorAll(".auth_tabs button")[1].classList.remove("active");
}

function showRegister() {
    document.getElementById("registerForm").classList.add("active");
    document.getElementById("loginForm").classList.remove("active");

    document.querySelectorAll(".auth_tabs button")[1].classList.add("active");
    document.querySelectorAll(".auth_tabs button")[0].classList.remove("active");
}
</script>
</div>
</body>
</html>