<?php
session_start();
include "db.php";
include "header.php";
if(isset($_SESSION['login_error'])){
    echo "<div class='error-msg'>".$_SESSION['login_error']."</div>";
    unset($_SESSION['login_error']);}

if(!isset($_SESSION['username'])){
    header("Location: auth.php");
    exit();
}

$username = $_SESSION['username'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $amount = $_POST['amount'];

    if($amount <= 0){
         $_SESSION['login_error'] = "Please enter a valid amount";
        header("Location: withdraw.php");
        exit();
    }

    // get wallet balance
    $result = mysqli_query($conn,
    "SELECT balance FROM wallets WHERE username='$username'");

    $wallet = mysqli_fetch_assoc($result);

    $balance = $wallet['balance'] ?? 0;

    // 🚨 VALIDATION CHECK
    if($amount > $balance){
          $_SESSION['login_error'] = "Insufficient funds";
        header("Location: withdraw.php");
        exit();
    }

    // deduct balance
    $update = "UPDATE wallets 
               SET balance = balance - $amount 
               WHERE username='$username'";

    mysqli_query($conn, $update);

    $_SESSION['success_msg'] = "Withdrawal successful";
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Withdraw</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="addproduct_body">

<div class="withdraw_container">

<div class="withdraw_card">

    <div class="withdraw_title">Withdraw Money</div>

    <?php


    // show current balance
    $bal_result = mysqli_query($conn,
    "SELECT balance FROM wallets WHERE username='$username'");

    $bal = mysqli_fetch_assoc($bal_result);
    $current_balance = $bal['balance'] ?? 0;
    ?>

    <div class="balance_box">
        Current Balance: R <?php echo number_format($current_balance,2); ?>
    </div>

    <form method="POST">

        <input type="number" name="amount" class="withdraw_input"
               placeholder="Enter amount (R)" required>

        <button type="submit" class="deposit_btn">
            Withdraw
        </button>

    </form>

</div>
</div>

</body>
</html>