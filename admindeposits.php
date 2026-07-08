<?php
include "db.php";
session_start();

// Optional: admin check (adjust to your system)
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1){
    header("Location: auth.php");
    exit();
}

$sql = "SELECT * FROM payfast_transactions ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Deposits</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="sales_body">

<div class="sales_container">

    <h1 class = "sales_title">All PayFast Deposits</h1>

    <div class = "sales_wrapper">
    <table class="sales_table">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Amount</th>
            <th>Payment ID</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td>R <?php echo $row['amount']; ?></td>
            <td><?php echo $row['payment_id']; ?></td>
            <td>
                <span class="status <?php echo strtolower($row['status']); ?>">
                    <?php echo $row['status']; ?>
                </span>
            </td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php } ?>

    </table>
    </div>
</div>

</body>
</html>