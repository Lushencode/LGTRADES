<?php
session_start();
include "db.php";
include "header.php";

$product_id = $_GET['product_id'];

$sql = "SELECT * FROM products WHERE product_id='$product_id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);


if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    $username = "";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['product_name']; ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body class="productdetail_body">



<div class="productdetail_container">

    <div class="productdetail_image">
        <img src="product_pics/<?php echo $product['product_image']; ?>">
    </div>

    <div class="productdetail_details">

        <div class="productdetail_name">
            <?php echo $product['product_name']; ?>
        </div>

        <div class="productdetail_condition">
            <?php echo $product['product_condition']; ?>
        </div>

        <div class="productdetail_price">
            R<?php echo $product['product_price']; ?>
        </div>

        <div class="productdetail_desc">
            <?php echo $product['product_description']; ?>
        </div>

    
        <?php if($username == $product['username']){ ?>
        <div class='own_product_msg'>
        You cannot purchase items you are selling.
      </div>
        
        <?php } elseif(isset($_SESSION['username'])) { ?>
          
            <a class="productdetail_buybtn" href="buyproduct.php?product_id=<?php echo $product['product_id']; ?>">
        Buy Now
        </a>
        <?php } else { 
             $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];?>

        <a class="productdetail_buybtn" href="auth.php">
        Login To Buy
        </a>

        <?php } ?>

    </div>

</div>

</body>
</html>