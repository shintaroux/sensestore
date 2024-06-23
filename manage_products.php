<?php
include '../includes/session.php';
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<?php include '../includes/adminheader.php';?>
    <div class="container-managed">
        <h1>Manage Products</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
        <form method="POST" action="../scripts/product_script.php" class="product-manage-form">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" placeholder="Price" required>
            <button type="submit" name="action" value="add">Add Product</button>
        </form>
        <ul class="product-manage-list">
            <?php foreach ($products as $product): ?>
                <li>
                    <span class="product-manage-name"><?php echo $product['name']; ?></span>
                    <span class="product-manage-price"><?php echo $product['price']; ?></span>
                    <form method="POST" action="../scripts/product_script.php" class="product-manage-delete-form">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
