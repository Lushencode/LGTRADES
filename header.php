<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<link rel="stylesheet" href="style.css">

<div class="navbar">

    <div class="nav-left">

        <a href="home.php">
            <img src="logo.png" class="logo">
        </a>

        <div class="brand">
            LG TRADES
        </div>

    </div>

    <div class="nav-right">

        <?php
        if(isset($_SESSION['username'])){
        ?>

            <span class="welcome-user">
                <?php echo $_SESSION['username']; ?>
            </span>

            <a href="home.php">Home</a>

            <a href="dashboard.php">Dashboard</a>

            <?php
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            ?>
                <a href="admindashboard.php">Admin Panel</a>
            <?php
            }
            ?>

            <a href="logout.php">Logout</a>

        <?php
        } else {
        ?>
            

            <a href="home.php">Home</a>

            <a href="auth.php">Login/Register</a>

        <?php
        }
        ?>

    </div>

</div>