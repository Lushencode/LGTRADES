<?php
session_start();
include "db.php";

if(!isset($_SESSION['username'])){
    header("Location: auth.php");
    exit();
}

$sale_id = $_GET['sale_id'];

/* GET SALE */
$sale = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM sales WHERE sale_id='$sale_id'"));

if($sale == NULL){
    echo "Sale not found";
    exit();
}

$seller = $sale['seller_username'];
$amount = $sale['amount'];

/* ADD MONEY TO SELLER WALLET */
mysqli_query($conn,
"UPDATE wallets
 SET balance = balance + '$amount'
 WHERE username='$seller'");

/* COMPLETE ORDER */
mysqli_query($conn,
"UPDATE sales
 SET order_status='Completed'
 WHERE sale_id='$sale_id'");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product delivered</title>
<link rel="stylesheet" href="style.css">


</head>

<body class="release_body">

<div class="release_card">

    <div class="release_icon">
        ✅
    </div>

    <div class="release_title">
        Product delivered successfully
    </div>

    <div class="release_text">
        The buyer confirmed delivery.
        <br>
        Funds have now been released to the seller.
    </div>

    <div class="release_amount">
        R<?php echo number_format($amount,2); ?>
    </div>

    <div class="release_info">

        <p>
            <span class="release_label">Sale ID:</span>
            #<?php echo $sale_id; ?>
        </p>

        <p>
            <span class="release_label">Seller:</span>
            <?php echo $seller; ?>
        </p>

        <p>
            <span class="release_label">Order Status:</span>
            Completed
        </p>

    </div>

    <a class="release_btn"
       href="javascript:history.back()">

       Return to My Sales

    </a>

    <div class="release_redirect">
        Redirecting automatically...
    </div>

</div>

<script>

setTimeout(function(){

    window.location.href = "javascript:history.back()";

},3000);

</script>

</body>
</html>