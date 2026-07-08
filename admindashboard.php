<?php
session_start();
include "db.php";
include "header.php";
if(isset($_SESSION['success_msg'])){
    echo "<div class='success-msg'>".$_SESSION['success_msg']."</div>";
    unset($_SESSION['success_msg']);
}



/* CHECK ADMIN */
if ($_SESSION['admin'] != 1) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: dashboard.php");
    exit();
}

/* GET ALL USERS */
$users_sql = "SELECT * FROM users where 1=1";
$users_result = mysqli_query($conn, $users_sql);

/* GET ALL PRODUCTS */
$products_sql = "SELECT * FROM products where 1=1";
$products_result = mysqli_query($conn, $products_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="style.css">

  
</head>

<body class="admin_body">


<div class="admin_container">
    <br>
   <a class="dash_btnheader" href="adminsales.php">View all sales</a>
    <h1>Admin Dashboard</h1>
    <br>

    <!-- USERS -->
    <h2 class="section-title">Users</h2>

    <table  class="admin_table">

        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php while($user = mysqli_fetch_assoc($users_result)) { ?>

        <tr>

            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['surname']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phone_number']; ?></td>

            <td>

                <div class="admin_action-buttons">

                    <a class="admin_edit-btn"
                       href="edituser.php?username=<?php echo $user['username']; ?>">
                        Edit
                    </a>

                    <a class="admin_delete-btn"
                       href="deleteuser.php?username=<?php echo $user['username']; ?>"
                       onclick="return confirm('Delete this user?');">
                        Delete
                    </a>

                </div>

            </td>

        </tr>

        <?php } ?>
    <div class="admin_table-wrapper">

    </table>
    <br>

    <!-- PRODUCTS -->
    <h2 class="section-title">Products</h2>

    <table class="admin_table">

        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Condition</th>
            <th>Category</th>
            <th>Seller</th>
            <th>Actions</th>
        </tr>

        <?php while($product = mysqli_fetch_assoc($products_result)) { ?>

        <tr>

            <td>

                <img
                    class="admin_product-img"
                    src="product_pics/<?php echo $product['product_image']; ?>"
                >

            </td>

            <td><?php echo $product['product_name']; ?></td>

            <td><?php echo $product['product_description']; ?></td>

            <td>R<?php echo $product['product_price']; ?></td>

            <td><?php echo $product['product_condition']; ?></td>

            <td><?php echo $product['product_category']; ?></td>

            <td><?php echo $product['username']; ?></td>

            <td>

                <div class="admin_action-buttons">

                    <a class="admin_view-btn"
                     href="productdetail.php?product_id=<?php echo $product['product_id']; ?>">
                     View
                    </a>
                    

                    <a class="admin_edit-btn"
                       href="editproduct.php?product_id=<?php echo $product['product_id']; ?>">
                        Edit
                    </a>

                    <a class="admin_delete-btn"
                       href="deleteproduct.php?product_id=<?php echo $product['product_id']; ?>"
                       onclick="return confirm('Delete this product?');">
                        Delete
                    </a>
                    

                </div>

            </td>

        </tr>

        <?php } ?>

    </table>
    
</div>
</div>

</body>
</html>


