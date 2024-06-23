<?php
include 'includes/session.php';
include 'config/database.php';

$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'includes/header.php';?>
    <div class="contact-container">
    <div class="contact-title"><h1>Contact Us</h1></div>
    <a href="https://facebook.com" div class="contact-info" target="_blank">
        <img src="images/facebook.png" alt="facebook" class="icon"><div class="contact-text">Facebook</div>
    </a>
    <a href="https://x.com" div class="contact-info" target="_blank">
        <img src="images/x.png" alt="x" class="icon"><div class="contact-text">Twitter</div>
    </a>
    <a href="https://instagram.com" div class="contact-info" target="_blank">
        <img src="images/ig.png" alt="ig" class="icon"><div class="contact-text">Instagram</div>
    </a>
    <a href="https://tiktok.com" div class="contact-info" target="_blank">
        <img src="images/tiktok.png" alt="tiktok" class="icon"><div class="contact-text">Tiktok</div>
    </a>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
