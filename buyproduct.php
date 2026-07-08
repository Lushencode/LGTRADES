<?php
session_start();
include "db.php";
include "header.php";

if(!isset($_SESSION['username'])){
     $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: auth.php");
    exit();
}

$buyer = $_SESSION['username'];
$product_id = $_GET['product_id'];

$message = "";
$message_class = "";

/* GET PRODUCT */
$product_sql = "SELECT * FROM products 
                WHERE product_id='$product_id' AND sold=0";

$product_result = mysqli_query($conn, $product_sql);
$product = mysqli_fetch_assoc($product_result);

if(!$product){
    $message = "Product not available";
    $message_class = "buy_error";
}else{

    $seller = $product['username'];
    $amount = $product['product_price'];

    /* GET BUYER WALLET */
    $wallet_sql = "SELECT * FROM wallets 
                   WHERE username='$buyer'";

    $wallet_result = mysqli_query($conn, $wallet_sql);
    $wallet = mysqli_fetch_assoc($wallet_result);

     $user = "SELECT * FROM user 
                   WHERE username='$buyer'";

    $user_result = mysqli_query($conn, $wallet_sql);
    $user = mysqli_fetch_assoc($user_result);


    if($wallet['balance'] < $amount){

        $message = "Insufficient wallet balance";
        $message_class = "buy_error";

    }else{

        /* DEDUCT MONEY */
        mysqli_query($conn,
        "UPDATE wallets 
         SET balance = balance - $amount
         WHERE username='$buyer'");

        /* CREATE SALE */
        mysqli_query($conn,
        "INSERT INTO sales
        (product_id, seller_username, buyer_username, amount, order_status)

        VALUES

        ('$product_id', '$seller', '$buyer', '$amount', 'Paid')");

        /* MARK PRODUCT SOLD */
        mysqli_query($conn,
        "UPDATE products
         SET sold=1
         WHERE product_id='$product_id'");

        $message = "Purchase Successful";
        $message_class = "buy_success";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Product</title>
<link rel="stylesheet" href="style.css">

</head>

<body class="addproduct_body">



<div class="buy_container">

    <div class="buy_card">

        <?php if(isset($product['product_image'])){ ?>

            <img
            class="buy_image"
            src="product_pics/<?php echo $product['product_image']; ?>">

        <?php } ?>

        <div class="buy_product_name">
            <?php echo $product['product_name'] ?? 'Product'; ?>
        </div>

        <div class="buy_price">
            R<?php echo $product['product_price'] ?? '0'; ?>
        </div>

        <div class="buy_message <?php echo $message_class; ?>">
            <?php echo $message; ?>
        </div>

        <a class="buy_button" href="index.php">
            Return to Home
        </a>
        <a class="buy_button" href="userorders.php">My Orders</a>

    </div>

</div>

</body>
</html>