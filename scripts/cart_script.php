<?php
include '../config/database.php';
include '../includes/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id'];

    if ($action == 'add') {
        $product_id = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

       
        $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            
            $new_quantity = $cart_item['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':quantity', $new_quantity);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $product_id);
        } else {
            // Jika produk belum ada di keranjang, tambahkan sebagai item baru
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':quantity', $quantity);
        }

        if ($stmt->execute()) {
            header("Location: ../cart.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->errorInfo();
        }
    } elseif ($action == 'remove') {
        $id = $_POST['id'];

        $sql = "DELETE FROM cart WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: ../cart.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->errorInfo();
        }
    }
}
?>
