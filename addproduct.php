<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "db.php";
include "header.php";

if(isset($_SESSION['login_error'])){
    echo "<div class='error-msg'>".$_SESSION['login_error']."</div>";
    unset($_SESSION['login_error']);}


if (!isset($_SESSION['username'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: auth.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['username'];

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);

$product_description = mysqli_real_escape_string($conn, $_POST['product_description']);

$product_price = mysqli_real_escape_string($conn, $_POST['product_price']);

$product_condition = mysqli_real_escape_string($conn, $_POST['product_condition']);

$product_category = mysqli_real_escape_string($conn, $_POST['product_category']);

    // IMAGE
    $image_name = $_FILES['product_image']['name'];
    $temp_name = $_FILES['product_image']['tmp_name'];

    // folder path
    $target = "product_pics/" . basename($image_name);

    // move uploaded image
    move_uploaded_file($temp_name, $target);

    // save product
    $sql = "INSERT INTO products
    (username, product_name, product_description, product_price,
    product_condition, product_category, product_image)

    VALUES

    ('$username', '$product_name', '$product_description',
    '$product_price', '$product_condition',
    '$product_category', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_msg'] = "Product added successfully";
        header("Location:sellerdash.php");
        exit();

    } else {
        $_SESSION['login_error'] ="Product has not been successfully added please check product details";
        header("Location:addproduct.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
<link rel="stylesheet" href="style.css">
</head>

<body class ="addproduct_body">

<div class="addproduct_container">

    <h1 class = "addproduct_h1">Add Product</h1>

    <?php
    if($error != ""){
        echo "<p class='error'>$error</p>";
    }
    ?>

    <form class ="addproduct_form" method="POST" enctype="multipart/form-data">

        <input class="addproduct_input"
            type="text"
            name="product_name"
            placeholder="Product Name"
            required>

        <textarea class="addproduct_textarea"
            name="product_description"
            placeholder="Product Description"
            required></textarea>

        <input class="addproduct_input"
                type="number"
               step="0.01"
               name="product_price"
               placeholder="Product Price"
               required>

        <!-- CONDITION -->
        <select class="addproduct_select" name="product_condition" required>
            <option value="">Select Condition</option>
            <option>New</option>
            <option>Used</option>
            <option>Refurbished</option>
        </select>

        <!-- CATEGORY -->
        <select class="addproduct_select" name="product_category" required>
            <option value="">Select Category</option>

            <option>Console</option>
            <option>PC</option>
            <option>Game</option>
            <option>Accessory</option>

        </select>

        <!-- IMAGE -->
        <input class="addproduct_input" type="file"
               name="product_image"
               accept="image/*"
               required>

        <button class="addproductbtn" type="submit">Add Product</button>

    </form>

</div>

</body>
</html>