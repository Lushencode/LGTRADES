<?php
session_start();
include "db.php";
include "header.php";

$id = $_GET['product_id'];

// get product
$sql = "SELECT * FROM products WHERE product_id='$id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['product_name'];
    $desc = $_POST['product_description'];
    $price = $_POST['product_price'];
    $condition = $_POST['product_condition'];
    $category = $_POST['product_category'];

    $update = "UPDATE products SET
        product_name='$name',
        product_description='$desc',
        product_price='$price',
        product_condition='$condition',
        product_category='$category'
        WHERE product_id='$id'";

    mysqli_query($conn, $update);
    if($_SESSION['admin']==1){
    $_SESSION['success_msg'] = "Product updated successfully";
    header("Location:admindashboard.php");
exit();
} else{
    $_SESSION['success_msg'] = "Product updated successfully";
    header("Location:dashboard.php");
        exit();
}

    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="addproduct_body">
<div class="addproduct_container">

<h2 class="addproduct_h1">Edit Product</h2>
<br><br>

<form class="addproduct_form" method="POST">
    <label class="formlabel" for="text">Product Name</label>
    <input  class="addproduct_input" type="text" name="product_name" value="<?php echo $product['product_name']; ?>">

    <label class="formlabel" for="text">Product Description</label>
    <textarea class="addproduct_input" name="product_description"><?php echo $product['product_description']; ?></textarea>

    <label class="formlabel" for="text">Product Price</label>
    <input class="addproduct_input" type="number" name="product_price" value="<?php echo $product['product_price']; ?>">

            <label class="formlabel" for="text">Product Condition</label>
            <select class="addproduct_select" name="product_condition" required>
            <option value=""><?php echo $product['product_condition']; ?></option>
            <option>New</option>
            <option>Used</option>
            <option>Refurbished</option>
            </select>

            <label class="formlabel" for="text">Product Category</label>
            <select class="addproduct_select" name="product_category" required>
            <option value=""><?php echo $product['product_category']; ?></option>

            <option>Console</option>
            <option>PC</option>
            <option>Game</option>
            <option>Accessory</option>

        </select><br>

    <button class="addproductbtn" type="submit">Update</button>

</form>
</div>
</body>
</html>