<?php
include '../includes/session.php';
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$history = $conn->query("SELECT * FROM purchase_history")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase History</title>
</head>
<body>
    <h1>Purchase History</h1>
    <a href="dashboard.php">Back to Dashboard</a><br><br>
    <ul>
        <?php foreach ($history as $item): ?>
            <li>
                User ID: <?php echo $item['user_id']; ?> - Product ID: <?php echo $item['product_id']; ?> - License ID: <?php echo $item['license_id']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
