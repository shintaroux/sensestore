<?php
include 'includes/session.php';
include 'config/database.php';

$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="contactdev5">
        <h1>Welcome to Our Shop</h1>
        <div class="slidercontainer">
            <div class="slider">
                <div class="slides">
                    <div class="slide"><img src="images/banner1.png" alt="Image 1"></div>
                    <div class="slide"><img src="images/banner2.png" alt="Image 2"></div>
                    <div class="slide"><img src="images/banner3.png" alt="Image 3"></div>
                </div>
            </div>
        </div>
        
        <div class="button-container">
            <a href="products.php" class="button">View Products</a>
            <a href="cart.php" class="button">View Cart</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    <script src="scripts/slider.js"></script>
</body>
</html>
