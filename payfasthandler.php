<?php
include "db.php";

// Get PayFast POST data
$username = $_POST['custom_str1'] ?? null;
$amount = $_POST['amount'] ?? null;
$payment_id = $_POST['m_payment_id'] ?? null;
$status = $_POST['payment_status'] ?? null;

// Safety check
if(!$username || !$amount || !$payment_id){
    exit();
}

// Convert full payload to JSON (raw_data)
$raw_data = json_encode($_POST);

// ONLY process successful payments
if($status == "COMPLETE"){

    // 1. Prevent duplicate processing
    $check = mysqli_query($conn,
    "SELECT * FROM payfast_transactions WHERE payment_id='$payment_id'");

    if(mysqli_num_rows($check) == 0){

        // 2. Insert transaction record
        $insert = "INSERT INTO payfast_transactions
        (username, amount, payment_id, status, raw_data)
        VALUES
        ('$username', '$amount', '$payment_id', 'COMPLETE', '$raw_data')";

        mysqli_query($conn, $insert);

        // 3. Ensure wallet exists
        $walletCheck = mysqli_query($conn,
        "SELECT * FROM wallets WHERE username='$username'");

        if(mysqli_num_rows($walletCheck) == 0){

            mysqli_query($conn,
            "INSERT INTO wallets (username, balance)
             VALUES ('$username', 0)");
        }

        // 4. Update wallet balance
        mysqli_query($conn,
        "UPDATE wallets
         SET balance = balance + $amount
         WHERE username='$username'");
    }
}
?>