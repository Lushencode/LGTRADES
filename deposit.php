<?php
session_start();
include "db.php";
include "header.php";

if(!isset($_SESSION['username'])){
    header("Location: auth.php");
    exit();
}

$username = $_SESSION['username'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $amount = $_POST['amount'];

    if($amount <= 0){
        $_SESSION['error'] = "Enter a valid amount";
        header("Location: deposit.php");
        exit();
    }

    // PayFast credentials (SANDBOX)
    $merchant_id = "10049426";
    $merchant_key = "gi0joo03o3t5b";

    $data = array(
        "merchant_id" => $merchant_id,
        "merchant_key" => $merchant_key,
        "return_url" => "http://localhost/website1/depositsuccess.php",
        "cancel_url" => "http://localhost/website1/depositcancel.php",
        "notify_url" => "http://localhost/website1/payfast_notification.php",

        "m_payment_id" => uniqid("DEP_"),
        "amount" => number_format($amount, 2, '.', ''),
        "item_name" => "Wallet Deposit",

        // IMPORTANT: send username safely
        "custom_str1" => $username
    );

    $pf_url = "https://sandbox.payfast.co.za/eng/process";
    ?>

    <form id="payfastForm" action="<?= $pf_url ?>" method="post">
        <?php foreach ($data as $key => $value): ?>
            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
        <?php endforeach; ?>
    </form>

    <script>
        document.getElementById("payfastForm").submit();
    </script>

    <?php
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deposit</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="addproduct_body">

<div class="deposit_container">
<div class="deposit_card">

    <div class="deposit_title">Deposit Money</div>

    <form method="POST">
        <input type="number" name="amount" class="deposit_input" placeholder="Enter amount (R)" required>

        <button type="submit" class="deposit_btn">
            Pay with PayFast
        </button>
    </form>

</div>
</div>

</body>
</html>