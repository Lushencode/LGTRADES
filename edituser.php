<?php
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['username'])) {
    header("Location: auth.php");
    exit();
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
$username = $_GET['username'];
} else {
    $username = $_SESSION['username'];
}


$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];

    $update = "UPDATE users SET
        name='$name',
        surname='$surname',
        email='$email',
        phone_number='$phone',
        street_address='$street_address',
        city='$city',
        province='$province',
        postal_code='$postal_code'
        
        WHERE username='$username'";

if(mysqli_query($conn, $update)){

   
    if($_SESSION['admin']==1){
    $_SESSION['success_msg'] = "User details updated successfully";
    header("Location:admindashboard.php");
exit();
} else{$_SESSION['success_msg'] = "Profile updated successfully";
    header("Location: dashboard.php");
    exit();}
}else{

    $_SESSION['error_msg'] = "Incorrect details entered";
    header("Location: edituser.php?username=$username");
    exit();
}


}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
<link rel="stylesheet" href="style.css">
</head>

<body class="addproduct_body">
<div class = "addproduct_container">

<div class="box">

    <h1>Edit Profile</h1>
    <br></br>

    <form class="addproduct_form" method="POST">
        <label class="formlabel" for="text">Name</label>
        <input class= "addproduct_input" type="text" name="name"
               value="<?php echo $user['name']; ?>"
               placeholder="Name" required>
            
        
        <label class="formlabel" for="text">Surname</label>
        <input class= "addproduct_input" type="text" name="surname"
               value="<?php echo $user['surname']; ?>"
               placeholder="Surname" required>

        <label class="formlabel" for="text">Email</label>
        <input class= "addproduct_input" type="email" name="email"
               value="<?php echo $user['email']; ?>"
               placeholder="Email" required>

        <label class="formlabel" for="text">Phone Number</label>
        <input class= "addproduct_input" type="text" name="phone_number"
               value="<?php echo $user['phone_number']; ?>"
               placeholder="Phone Number" required> 
        
        <label class="formlabel">Street Address</label>
        <input class="addproduct_input" type="text" name="street_address"
         value="<?php echo $user['street_address']; ?>"
         placeholder="Street Address">

        <label class="formlabel">City</label>
        <input class="addproduct_input" type="text" name="city"
         value="<?php echo $user['city']; ?>"
         placeholder="City">

        <label class="formlabel">Province</label>
        <input class="addproduct_input" type="text" name="province"
         value="<?php echo $user['province']; ?>"
         placeholder="Province">

        <label class="formlabel">Postal Code</label>
        <input class="addproduct_input" type="text" name="postal_code"
         value="<?php echo $user['postal_code']; ?>"
         placeholder="Postal Code">

        <button class= "addproductbtn" type="submit">Update Profile</button>

    </form>

</div>
</div>
</body>
</html>