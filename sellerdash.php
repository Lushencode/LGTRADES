<?php
session_start();
include "db.php";
include "header.php";

if(isset($_SESSION['success_msg'])){
    echo "<div class='success-msg'>".$_SESSION['success_msg']."</div>";
    unset($_SESSION['success_msg']);
}

if(!isset($_SESSION['username'])){
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: auth.php");
    exit();
}

$user = $_SESSION['username'];

/* GET SELLER PRODUCTS */
$products_result = mysqli_query($conn,
"SELECT * FROM products
 WHERE username='$user'
 ORDER BY product_id DESC");

/* TOTAL PRODUCTS */
$total_products = mysqli_num_rows($products_result);

/* TOTAL SALES */
$sales_result = mysqli_query($conn,
"SELECT * FROM sales
 WHERE seller_username='$user'");

$total_sales = mysqli_num_rows($sales_result);

/* TOTAL EARNINGS */
$total_earnings = 0;

$earnings_result = mysqli_query($conn,
"SELECT * FROM sales
 WHERE seller_username='$user'
 AND order_status='Completed'");

while($earnings = mysqli_fetch_assoc($earnings_result)){
    $total_earnings += $earnings['amount'];
}

/* GET WALLET */
$wallet_result = mysqli_query($conn,
"SELECT * FROM wallets
 WHERE username='$user'");

$wallet = mysqli_fetch_assoc($wallet_result);

$wallet_balance = $wallet['balance'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="style.css">

 
</head>

<body class="seller_body">


<div class="seller_container">

    <h1 class="seller_title">
        Seller Dashboard
    </h1>

    <div class="seller_stats">

        <div class="seller_stat_card">

            <div class="seller_stat_label">
                Wallet Balance
            </div>

            <div class="seller_stat_value">
                R<?php echo number_format($wallet_balance, 2); ?>
            </div>

        </div>

        <div class="seller_stat_card">

            <div class="seller_stat_label">
                Total Products
            </div>

            <div class="seller_stat_value">
                <?php echo $total_products; ?>
            </div>

        </div>

        <div class="seller_stat_card">

            <div class="seller_stat_label">
                Total Sales
            </div>

            <div class="seller_stat_value">
                <?php echo $total_sales; ?>
            </div>

        </div>

        <div class="seller_stat_card">

            <div class="seller_stat_label">
                Total Earnings
            </div>

            <div class="seller_stat_value">
                R<?php echo number_format($total_earnings, 2); ?>
            </div>

        </div>

    </div>

    <a class="seller_add_btn" href="addproduct.php">
        Add New Product
    </a>
    <a class="seller_add_btn" href="usersales.php">
        View sales
    </a>

    <h2 class="seller_products_title">
        My Products
    </h2>

    <?php if(mysqli_num_rows($products_result) > 0){ ?>

        <div class="seller_products_grid">

        <?php while($product = mysqli_fetch_assoc($products_result)){ ?>

            <div class="seller_product_card">

                <img
                class="seller_product_image"
                src="product_pics/<?php echo $product['product_image']; ?>">

                <div class="seller_product_name">
                    <?php echo $product['product_name']; ?>
                </div>

                <div class="seller_product_price">
                    R<?php echo $product['product_price']; ?>
                </div>

                <div class="seller_product_category">
                    <strong>Category:</strong>
                    <?php echo $product['product_category']; ?>
                </div>

                <div class="seller_product_condition">
                    <strong>Condition:</strong>
                    <?php echo $product['product_condition']; ?>
                </div>

                <div class="seller_buttons">

                    <a class="seller_btn seller_edit_btn"
                       href="editproduct.php?id=<?php echo $product['product_id']; ?>">

                       Edit

                    </a>

                    <a class="seller_btn seller_delete_btn"
                       href="deleteproduct.php?id=<?php echo $product['product_id']; ?>">

                       Delete

                    </a>

                </div>

            </div>

        <?php } ?>

        </div>

    <?php } else { ?>

        <div class="seller_empty">
            You have not listed any products yet.
        </div>

    <?php } ?>

</div>

</body>
</html>