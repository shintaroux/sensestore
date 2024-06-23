<?php
include '../config/database.php';
include '../includes/session.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status_code = $_POST['status_code'];
    $gross_amount = $_POST['gross_amount'];

    if ($status_code == 200) {
        $conn->beginTransaction();

        try {
            $payment_sql = "INSERT INTO payments (user_id, amount, payment_status) VALUES (:user_id, :amount, 'completed')";
            $payment_stmt = $conn->prepare($payment_sql);
            $payment_stmt->bindParam(':user_id', $user_id);
            $payment_stmt->bindParam(':amount', $gross_amount);
            $payment_stmt->execute();
            $payment_id = $conn->lastInsertId();

            $cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cart_items as $item) {
                $product_id = $item['product_id'];

                $license = $conn->query("SELECT * FROM licenses WHERE product_id = $product_id AND is_active = 1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                $license_id = $license['id'];

                $purchase_sql = "INSERT INTO purchase_history (user_id, product_id, license_id) VALUES (:user_id, :product_id, :license_id)";
                $purchase_stmt = $conn->prepare($purchase_sql);
                $purchase_stmt->bindParam(':user_id', $user_id);
                $purchase_stmt->bindParam(':product_id', $product_id);
                $purchase_stmt->bindParam(':license_id', $license_id);
                $purchase_stmt->execute();

                $update_license_sql = "UPDATE licenses SET is_active = 0 WHERE id = :license_id";
                $update_license_stmt = $conn->prepare($update_license_sql);
                $update_license_stmt->bindParam(':license_id', $license_id);
                $update_license_stmt->execute();
            }

            $clear_cart_sql = "DELETE FROM cart WHERE user_id = :user_id";
            $clear_cart_stmt = $conn->prepare($clear_cart_sql);
            $clear_cart_stmt->bindParam(':user_id', $user_id);
            $clear_cart_stmt->execute();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollBack();
            echo "Failed: " . $e->getMessage();
        }
    }
}
?>
