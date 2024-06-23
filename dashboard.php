<?php
include '../includes/session.php';
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/adminheader.php';?>
    <main class="dashboard">
        <h1>Welcome, Admin</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="view_history.php">View Purchase History</a></li>
            </ul>
        </nav>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
