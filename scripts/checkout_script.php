<?php
include '../config/database.php';
include '../includes/session.php';
include '../config/midtrans.php';

$user_id = $_SESSION['user_id'];
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id")->fetchAll(PDO::FETCH_ASSOC);

$total_amount = 0;
foreach ($cart_items as $item) {
    $product = $conn->query("SELECT * FROM products WHERE id = {$item['product_id']}")->fetch(PDO::FETCH_ASSOC);
    $total_amount += $product['price'] * $item['quantity'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_details = array(
        'order_id' => uniqid(),
        'gross_amount' => $total_amount,
    );

    $customer_details = array(
        'first_name' => $_SESSION['username'],
        'email' => $_SESSION['email'],
    );

    $transaction = array(
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
    );

    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    echo json_encode(['token' => $snapToken]);
    exit;
}
?>
