<?php
include '../includes/session.php';
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? null;

    if ($action == 'add') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        
        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
        $stmt->execute(['name' => $name, 'price' => $price]);
    } elseif ($action == 'delete' && $id) {
        // Check if the product is referenced in the cart table
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cart WHERE product_id = :id");
        $stmt->execute(['id' => $id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Handle the error (e.g., display a message to the user)
            $_SESSION['error'] = "Cannot delete product because it is referenced in the cart.";
        } else {
            $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);
        }
    }
}

header("Location: ../admin/manage_products.php");
exit;
?>
