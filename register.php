<?php

session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $surname = mysqli_real_escape_string($conn, $_POST["surname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone_number"]);
    $street_address = mysqli_real_escape_string($conn, $_POST["street_address"]);
    $city = mysqli_real_escape_string($conn, $_POST["city"]);
    $province = mysqli_real_escape_string($conn, $_POST["province"]);
    $postal_code = mysqli_real_escape_string($conn, $_POST["postal_code"]);

    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation
    if (
        empty($username) ||
        empty($name) ||
        empty($surname) ||
        empty($email) ||
        empty($phone) ||
        empty($street_address) ||
        empty($city) ||
        empty($province) ||
        empty($postal_code) ||
        empty($password) ||
        empty($confirm_password)
    ) {

        $_SESSION['login_error'] = "All fields are required.";
        header("Location: auth.php");
        exit();
    }

    if ($password !== $confirm_password) {

        $_SESSION['login_error'] = "Passwords do not match.";
        header("Location: auth.php");
        exit();
    }

    // Check if username or email already exists
    $check_sql = "SELECT * FROM users
                  WHERE username='$username'
                  OR email='$email'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {

        $_SESSION['login_error'] = "Username or email already exists.";
        header("Location: auth.php");
        exit();
    }

    if(!preg_match('/^[A-Za-z0-9]{5}$/', $username)){
    $_SESSION['login_error'] = "Username must be exactly 5 letters or numbers.";
    header("Location: auth.php");
    exit();
    }
    // Hash password
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $sql = "INSERT INTO users
            (
                username,
                name,
                surname,
                password,
                phone_number,
                email,
                admin,
                street_address,
                city,
                province,
                postal_code
            )
            VALUES
            (
                '$username',
                '$name',
                '$surname',
                '$hashed_password',
                '$phone',
                '$email',
                0,
                '$street_address',
                '$city',
                '$province',
                '$postal_code'
            )";

    if (mysqli_query($conn, $sql)) {

        // Create wallet
        $wallet_sql = "INSERT INTO wallets (username, balance)
                       VALUES ('$username', 0.00)";

        if (!mysqli_query($conn, $wallet_sql)) {
            die("Wallet Error: " . mysqli_error($conn));
        }

       $_SESSION['success_msg'] = "User successfully created";
       header("Location:auth.php");
        exit();

    } else {

        die("Database Error: " . mysqli_error($conn));
    }
}
?>