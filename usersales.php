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
 WHERE seller_username='$user'
 ORDER BY sale_date DESC");

/* TOTAL EARNINGS */
$total_earnings = 0;

$temp_result = mysqli_query($conn,
"SELECT * FROM sales
 WHERE seller_username='$user'
 AND order_status='Completed'");

while($earnings_row = mysqli_fetch_assoc($temp_result)){
    $total_earnings += $earnings_row['amount'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Sales</title>
    <link rel="stylesheet" href="style.css">


</head>

<body class="sales_body">



<div class="sales_container">

    <div class="sales_header">

        <h1 class="sales_title">My Sales</h1>

        <div class="sales_earnings">

            <div class="sales_earnings_label">
                Total Earnings
            </div>

            <div class="sales_earnings_amount">
                R<?php echo number_format($total_earnings, 2); ?>
            </div>

        </div>

    </div>

    <?php if(mysqli_num_rows($result) > 0){ ?>

        <div class="sales_grid">

        <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <div class="sales_card">

                <div class="sales_id">
                    Sale #<?php echo $row['sale_id']; ?>
                </div>

                <div class="sales_text">
                    <span class="sales_label">Product ID:</span>
                    <?php echo $row['product_id']; ?>
                </div>

                <div class="sales_text">
                    <span class="sales_label">Buyer:</span>
                    <?php echo $row['buyer_username']; ?>
                </div>

                <div class="sales_text">
                    <span class="sales_label">Date:</span>
                    <?php echo $row['sale_date']; ?>
                </div>

                <div class="sales_amount">
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

                <div class="sales_status <?php echo $status_class; ?>">
                    <?php echo $status; ?>
                </div>

                <br>

                <a class="sales_button"
                  href="orderdetails.php?sale_id=<?php echo $row['sale_id']; ?>&from=sales">

                   View Sale

                </a>

            </div>

        <?php } ?>

         
    <?php } else { ?>

        <div class="sales_empty">
            You currently have no sales.
        </div>

    <?php } ?>

</div>
<br>
<br>
<a class="sales_back-btn" href="sellerdash.php">Back</a>
</body>
</html>