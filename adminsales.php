<?php
include "db.php";
include "header.php";

$result = mysqli_query($conn,
"SELECT * FROM sales ORDER BY sale_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Sales</title>
<link rel="stylesheet" href="style.css">
   
</head>

<body class="sales_body">


<div class="sales_container">

    <h1 class="sales_title">All Sales</h1>

    <div class="sales_wrapper">

        <table class="sales_table">

            <tr>
                <th>Sale ID</th>
                <th>Product ID</th>
                <th>Seller</th>
                <th>Buyer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>
                <td><?php echo $row['sale_id']; ?></td>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['seller_username']; ?></td>
                <td><?php echo $row['buyer_username']; ?></td>
                <td>R<?php echo $row['amount']; ?></td>

                <td>
                    <?php
                        $status = $row['order_status'];

                        if($status == "Paid"){
                            echo "<span class='status_paid sales_badge'>Paid</span>";
                        }
                        elseif($status == "Shipped"){
                            echo "<span class='status_shipped sales_badge'>Shipped</span>";
                        }
                        elseif($status == "Delivered"){
                            echo "<span class='status_delivered sales_badge'>Delivered</span>";
                        }
                        elseif($status == "Completed"){
                            echo "<span class='status_completed sales_badge'>Completed</span>";
                        }
                    ?>
                </td>

                <td><?php echo $row['sale_date']; ?></td>
            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>