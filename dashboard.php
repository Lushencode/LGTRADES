<?php
session_start();
include "db.php";
include "header.php";

if(isset($_SESSION['success_msg'])){
    echo "<div class='success-msg'>".$_SESSION['success_msg']."</div>";
    unset($_SESSION['success_msg']);
}
if(isset($_SESSION['error_msg'])){
    echo "<div class='error-msg'>".$_SESSION['error_msg']."</div>";
    unset($_SESSION['error_msg']);
}


$username = $_SESSION['username'];

/* USER */
$user_sql = "SELECT * FROM users WHERE username='$username'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

/* PRODUCTS */
$sql = "SELECT * FROM products WHERE username='$username'";
$result = mysqli_query($conn, $sql);

/*wallet*/
$wallet_sql = "SELECT balance FROM wallets WHERE username='$username'";
$wallet_result = mysqli_query($conn, $wallet_sql);
$wallet = mysqli_fetch_assoc($wallet_result);

$balance = $wallet['balance'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">



</head>

<body class="dash_body">

<div class="dash_container">

    <!-- PROFILE -->
    <div class="dash_header">
        

        <h1>
            <?php echo $user['name'] . " " . $user['surname']; ?>
        </h1>

        <p>
            Username: <?php echo $user['username']; ?> |
            Email: <?php echo $user['email']; ?> |
            Phone: <?php echo $user['phone_number']; ?>
        </p>

        <div class="dash_buttons">

            <a class="dash_btnheader"
               href="edituser.php?username=<?php echo $user['username']; ?>">
               Edit Profile
            </a>

            <a class="dash_btnheader" href="sellerdash.php">
                Seller Dashboard
            </a>
            <a class="dash_btnheader" href="userorders.php">
                My Orders
            </a>
            


        </div>
        <div class="wallet-container">

    <div class="wallet-balance">
        💰 Balance: R <?php echo number_format($balance, 2); ?>
    </div>

    <div class="wallet-actions">

        <a href="deposit.php" class="wallet-btn deposit">
            Deposit
        </a>

        <a href="withdraw.php" class="wallet-btn withdraw">
            Withdraw
        </a>

    </div>

</div>


    </div>

    <!-- PRODUCTS -->
    <h2 class="dash_products_title">My Products</h2>

    <div class="dash_grid">

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

        <div class="dash_card">

            <img src="product_pics/<?php echo $row['product_image']; ?>">

            <h2><?php echo $row['product_name']; ?></h2>

            <p><?php echo $row['product_description']; ?></p>

            <p><b>Price:</b> R<?php echo $row['product_price']; ?></p>
            <p><b>Condition:</b> <?php echo $row['product_condition']; ?></p>
            <p><b>Category:</b> <?php echo $row['product_category']; ?></p>

            <div class="dash_actions">

                <a class="view"
                   href="productdetail.php?product_id=<?php echo $row['product_id']; ?>">
                   View
                </a>

                <a class="edit"
                   href="editproduct.php?product_id=<?php echo $row['product_id']; ?>">
                   Edit
                </a>

                <a class="delete"
                   href="deleteproduct.php?product_id=<?php echo $row['product_id']; ?>"
                   onclick="return confirm('Delete this product?')">
                   Delete
                </a>

            </div>

        </div>

    <?php } ?>

    </div>

</div>

</body>
</html>