<?php
include "db.php";
include "header.php";

/* SEARCH + FILTER + SORT */
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';

$sql = "SELECT * FROM products where 1=1";

/* SEARCH */
if (!empty($search)) {
    $sql .= " AND product_name LIKE '%$search%'";
}

/* CATEGORY FILTER */
if (!empty($category)) {
    $sql .= " AND product_category='$category'";
}

/* SORT */
if ($sort == "low") {
    $sql .= " ORDER BY product_price ASC";
} elseif ($sort == "high") {
    $sql .= " ORDER BY product_price DESC";
} else {
    $sql .= " ORDER BY product_id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>LG TRADES</title>

    <link rel="stylesheet" href="style.css">
</head>

<body class = "home_body">

<!-- HERO -->

<div class="hero">

    <h1>Welcome to LG TRADES</h1>

    <p>
        Buy the latest gaming consoles, accessories, PCs and games.
    </p>

    <a href="#products" class="hero-btn">
        Shop Now
    </a>

</div>
<form method="GET" class="home_search-bar">

    <input class="home_input" type="text" name="search" placeholder="Search products...">

    <select class="home_input" name="category">
        <option value="">All Categories</option>
        <option value="Console">Console</option>
        <option value="PC">PC</option>
        <option value="Game">Game</option>
        <option value="Accessory">Accessory</option>
    </select>

    <select class="home_input" name="sort">
        <option value="">Sort By</option>
        <option value="low">Price: Low to High</option>
        <option value="high">Price: High to Low</option>
    </select>

    <button type="submit">Search</button>

</form>

<!-- PRODUCTS -->

<div class="products-section" id="products">

    <h2 class="section-title">
        Featured Products
    </h2>

    <div class="home_products">

        <?php
        while($row = mysqli_fetch_assoc($result)){
        ?>

        <div class="product-card">


        <img  src="product_pics/<?php echo $row['product_image']; ?>"
            style="width:200px;
             border-radius:10px;"
            >
            <div class="product-name">
                <?php echo $row['product_name']; ?>
            </div>
            <div class="product-condition">
                <?php echo $row['product_condition']; ?>
             </div>

            <div class="product-description">
                <?php echo $row['product_description']; ?>
            </div>

            <div class="product-price">
                R<?php echo $row['product_price']; ?>
            </div>

            <?php if($row['sold']==0){?>             
            <a href="productdetail.php ?product_id=<?php echo $row['product_id']; ?>">
            <button class="home_viewbtn">View Product</button>
            </a>
            <?php } else { ?>
                <p class="sold_text">SOLD</p>
            <?php } ?>

        </div>

        <?php
        }
        ?>

    </div>

</div>

<footer>
    © 2026 LG TRADES - All Rights Reserved
</footer>

</body>
</html>