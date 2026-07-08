<?php
session_start();
include "db.php";
include "header.php";

if(!isset($_SESSION['username'])){
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: auth.php");
    exit();
}

$user = $_SESSION['username'];

$result = mysqli_query($conn,
"SELECT * FROM sales
 WHERE buyer_username='$user'
 ORDER BY sale_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
<link rel="stylesheet" href="style.css">

  
</head>

<body class="orders_body">



<div class="orders_container">

    <h1 class="orders_title">My Orders</h1>

    <?php if(mysqli_num_rows($result) > 0){ ?>

        <div class="orders_grid">

        <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <div class="orders_card">

                <div class="orders_id">
                    Order #<?php echo $row['sale_id']; ?>
                </div>

                <div class="orders_text">
                    <strong>Product ID:</strong>
                    <?php echo $row['product_id']; ?>
                </div>

                <div class="orders_text">
                    <strong>Seller:</strong>
                    <?php echo $row['seller_username']; ?>
                </div>

                <div class="orders_price">
                    R<?php echo $row['amount']; ?>
                </div>

                <?php
                    $status = $row['order_status'];
                    $status_class = "";

                    if($status == "Paid"){
                        $status_class = "status_paid";
                    }
                    elseif($status == "Shipped"){
                        $status_class = "status_shipped";
                    }
                    elseif($status == "Delivered"){
                        $status_class = "status_delivered";
                    }
                    elseif($status == "Completed"){
                        $status_class = "status_completed";
                    }
                ?>

                <div class="orders_status <?php echo $status_class; ?>">
                    <?php echo $status; ?>
                </div>

                <br>

                <a class="orders_button"
                   href="orderdetails.php?sale_id=<?php echo $row['sale_id']; ?>&from=orders">
                   View Order
                </a>

            </div>

        <?php } ?>

        </div>

    <?php } else { ?>

        <div class="orders_empty">
            You have no orders yet.
        </div>

    <?php } ?>

</div>

</body>
</html>