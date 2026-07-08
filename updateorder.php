<?php
session_start();
include "db.php";

if(!isset($_SESSION['username'])){
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: auth.php");
    exit();
}

$sale_id = $_GET['sale_id'];
$status = $_GET['status'];

$update = mysqli_query($conn,
"UPDATE sales 
 SET order_status='$status'
 WHERE sale_id='$sale_id'");

$success = $update ? true : false;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Order</title>
    <link rel="stylesheet" href="style.css">


</head>

<body class="update_body">

<div class="update_card">

    <div class="update_title">
        Order Update
    </div>

    <?php if($success){ ?>

        <div class="update_text success">
            Order status successfully updated to:
            <br><br>
            <b><?php echo $status; ?></b>
        </div>

    <?php } else { ?>

        <div class="update_text error">
            Failed to update order status.
        </div>

    <?php } ?>

    <a class="update_btn"
       href="javascript:history.back()">
       Go Back
    </a>

    <div class="auto_redirect" >
        You will be redirected automatically...
    </div>

</div>

<script>
    setTimeout(function(){
        window.location.href = "javascript:history.back()";
    }, 3000);
</script>

</body>
</html>