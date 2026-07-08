<?php
session_start();
include "db.php";

$id = $_GET['product_id'];

$sql = "DELETE FROM products WHERE product_id='$id'";

mysqli_query($conn, $sql);

if($_SESSION['admin']==1){
       $_SESSION['success_msg'] = "Product deleted successfully";
       header("Location:admindashboard.php");
exit();
} else{
       $_SESSION['success_msg'] = "Product deleted successfully";
       header("Location:dashboard.php");
        exit();
}
?>