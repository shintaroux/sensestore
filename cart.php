<?php
include 'includes/session.php';
include 'config/database.php';

$user_id = $_SESSION['user_id'];
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="cart-container">
    <h1 class="cart-title">My Cart</h1>
    <ul class="cart-items">
        <?php
        $total_price = 0;
        foreach ($cart_items as $item):
            $product = $conn->query("SELECT * FROM products WHERE id = {$item['product_id']}")->fetch(PDO::FETCH_ASSOC);
            $item_total = $product['price'] * $item['quantity'];
            $total_price += $item_total;
        ?>
            <li class="cart-item">
                <div class="item-details">
                    <span class="item-name"><?php echo $product['name']; ?></span>
                    <span class="item-quantity"><?php echo "Quantity: " . $item['quantity']; ?></span>
                    <span class="item-price"><?php echo "IDR " . number_format($product['price']); ?></span>
                    <span class="item-total"><?php echo "Total: IDR " . number_format($item_total); ?></span>
                </div>
                <form method="POST" action="scripts/cart_script.php" class="cart-form">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <button type="submit" name="action" value="remove" class="cart-remove-button">Remove</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="cart-summary">
        <div class="cart-total">
            <strong>Total Price: </strong><span><?php echo "IDR " . number_format($total_price); ?></span>
        </div>
        <a href="products.php" class="add-more-items-button">Add More Items</a>
    </div>
    <a href="checkout.php" class="checkout-link">Proceed to Checkout</a>
</div>



    <?php include 'includes/footer.php'; ?>
</body>
</html>
