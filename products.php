<?php
include 'includes/session.php';
include 'config/database.php'; // Sesuaikan dengan nama file dan lokasi yang tepat

$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Showcase</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include 'includes/header.php';?>
    
<div class="product-container"> 
<div class="product-title"><h1>Product Showcase</h1></div>
<div class="product-list">    
<?php foreach ($products as $product): ?>
    <div class="product-card">
        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price">IDR <?php echo htmlspecialchars($product['price']); ?></p>
            <form method="POST" action="scripts/cart_script.php" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label for="quantity-<?php echo $product['id']; ?>"></label>
                <input type="number" id="quantity-<?php echo $product['id']; ?>" name="quantity" value="1" min="1" class="quantity-input">
                <button type="submit" name="action" value="add" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</div>
</div>

    
<?php include 'includes/footer.php';?>
</body>
</html>


