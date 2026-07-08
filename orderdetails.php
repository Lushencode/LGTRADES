<?php
session_start();
include "db.php";
include "header.php";



if(!isset($_SESSION['username'])){
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: auth.php");
    exit();
}

$username = $_SESSION['username'];
$sale_id = $_GET['sale_id'];
$from = $_GET['from'] ?? 'orders';

$order = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM sales WHERE sale_id='$sale_id'"));

$buyer_username = $order['buyer_username'];

$buyer = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT street_address, city, province, postal_code 
 FROM users 
 WHERE username='$buyer_username'"));


if($order == NULL){
    echo "Order not found";
    exit();
}

$status = $order['order_status'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="style.css">

</head>

<body class="orderdetails_body">


<div class="orderdetails_container">

    <div class="orderdetails_card">

        <h1 class="orderdetails_title">
            Order #<?php echo $order['sale_id']; ?>
        </h1>

        <div class="orderdetails_row">
            <span class="orderdetails_label">Product ID:</span>
            <?php echo $order['product_id']; ?>
        </div>

        <div class="orderdetails_row">
            <span class="orderdetails_label">Buyer:</span>
            <?php echo $order['buyer_username']; ?>
        </div>

        <div class="orderdetails_row">
            <span class="orderdetails_label">Seller:</span>
            <?php echo $order['seller_username']; ?>
        </div>

        <div class="orderdetails_row">
            <span class="orderdetails_label">Order Date:</span>
            <?php echo $order['sale_date']; ?>
        </div>
        <div class="order_box">

    <h3>Delivery Address</h3>

    <p><b>Street:</b> <?php echo $buyer['street_address']; ?></p>
    <p><b>City:</b> <?php echo $buyer['city']; ?></p>
    <p><b>Province:</b> <?php echo $buyer['province']; ?></p>
    <p><b>Postal Code:</b> <?php echo $buyer['postal_code']; ?></p>

</div>

        <div class="orderdetails_price">
            R<?php echo $order['amount']; ?>
        </div>

        <?php
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

        <div class="orderdetails_status <?php echo $status_class; ?>">
            <?php echo $status; ?>
        </div>

        <div class="orderdetails_actions">

            <!-- SELLER ACTION -->
            <?php if($username == $order['seller_username']){ ?>

                <?php if($status == "Paid"){ ?>

                    <a class="orderdetails_btn btn_ship"
                       href="updateorder.php?sale_id=<?php echo $sale_id; ?>&status=Shipped">

                       Mark as Shipped

                    </a>

                <?php } ?>

            <?php } ?>

            <!-- BUYER ACTION -->
            <?php if($username == $order['buyer_username']){ ?>

                <?php if($status == "Shipped"){ ?>

                    <a class="orderdetails_btn btn_deliver"
                       href="releasepayment.php?sale_id=<?php echo $sale_id; ?>&status=Delivered">

                       Confirm Delivered

                    </a>

                <?php } ?>

            <?php } ?>



        </div>

        <?php if($from == "sales"){ ?>

    <a class="addproductbtn" href="usersales.php">
        Back
    </a>

        <?php } else { ?>

    <a class="orderdetails_back" href="userorders.php">
        Back
    </a>

    <?php } ?>

    </div>

</div>
<script>
document.addEventListener("visibilitychange", function(){
    if(document.visibilityState === "visible"){
        location.reload();
    }
});
</script>

</body>
</html>