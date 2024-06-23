<?php
include 'includes/session.php';
include 'config/database.php';
include 'config/midtrans.php';

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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript">
        function pay() {
            fetch('checkout.php', {
                method: 'POST'
            }).then(response => response.json()).then(data => {
                snap.pay(data.token);
            });
        }
    </script>
    <style>
        .container {
            margin: auto;
            background:#fff;
            padding: 20px 200px 50px 200px;
        }
        .container p{
            text-align: center;
            font-size: 20px
        }

        .payment-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
            margin:auto;
        }

        .payment-option:hover {
            background-color: #ccc;
        }

        .payment-option {
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 30%;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .payment-option img {
            max-width: 50px;
            margin-bottom: 10px;
        }
        .payment-option p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        .payment-option span {
            display: block;
            font-size: 14px;
            color: #666;
        }
        .payment-option .price {
            color: #e74c3c;
            font-size: 18px;
            font-weight: bold;
        }
        .btn-pay {
            text-align: center;
            margin:auto;
            display: flex;
            width: 70%;
            background: #27ae60;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 10px;
            transition: background 0.3s ease;
            margin-bottom: 40px;
        }
        .btn-pay:hover {
            background: #2ecc71;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h1>Checkout</h1>
        <p>Total Amount: Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></p>
        <div class="payment-options">
            <div class="payment-option">
                <img src="images/dana.png" alt="DANA">
                <p>Bayar dengan DANA</p>
                <span class="price">Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></span>

            </div>
            <div class="payment-option">
                <img src="images/bank.png" alt="Bank Transfers">
                <p>Bank Transfers</p>
                <span class="price">Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></span>

            </div>
            <div class="payment-option">
                <img src="images/gopay.png" alt="GoPay">
                <p>Bayar dengan GoPay</p>
                <span class="price">Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></span>

            </div>
            <div class="payment-option">
                <img src="images/qris.png" alt="QRIS">
                <p>Pay with QRIS</p>
                <span class="price">Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></span>

            </div>
            <div class="payment-option">
                <img src="images/shopee.png" alt="Shopee">
                <p>Bayar dengan ShopeePay</p>
                <span class="price">Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></span>
            </div>
            <div class="payment-option">
                <img src="images/ovo.png" alt="OVO">
                <p>Bayar dengan OVO</p>
                <span class="price">Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></span>

            </div>
        </div>
        <button class="btn-pay" onclick="pay()">Pay Now</button>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
