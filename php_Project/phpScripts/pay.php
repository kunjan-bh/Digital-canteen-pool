<?php
    session_start();
    include ('../includes/dbconn.php');
    $order_id = $_GET['order_id'];
    $food_name = $_GET['food_name'];
    $price = intval($_GET['price']);
    $secret = '8gBm/:&EnhH.1/q'; 
    $tax_amount = (int)10;
    $transaction_uuid = uniqid(); 
    $total_amount = $price + $tax_amount;
    $product_code = 'EPAYTEST';
    
    $message = "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=$product_code";
    $signature = base64_encode(hash_hmac('sha256', $message, $secret, true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esewa Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4 text-success">Pay via Esewa</h2>
            <p class="text-center fs-5">For food: <strong><?php echo "$food_name";?></strong></p>
            <p class="text-center fs-5">Total Price: <strong>Rs. <?php echo "$price";?></strong></p>
            
            <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
                <input type="hidden" name="amount" value="<?php echo $price ;?>" required>
                <input type="hidden" name="tax_amount" value="<?php echo $tax_amount ;?>" required>
                <input type="hidden" name="total_amount" value="<?php echo $total_amount ;?>" required>
                <input type="hidden" name="transaction_uuid" value="<?php echo $transaction_uuid ;?>" required>
                <input type="hidden" name="product_code" value="EPAYTEST" required>
                <input type="hidden" name="product_service_charge" value="0" required>
                <input type="hidden" name="product_delivery_charge" value="0" required>
                <input type="hidden" name="success_url" value="http://localhost/Kunjan_Bhatt_24152365_PHP/php_Project/phpScripts/payment_success.php?order_id=<?php echo $order_id;?>" required>
                <input type="hidden" name="failure_url" value="http://localhost/Kunjan_Bhatt_24152365_PHP/php_Project/phpScripts/payment_fail.php" required>
                <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
                <input type="hidden" name="signature" value="<?php echo $signature ;?>" required>
                
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Pay Now</button>
                </div>
                <div class="text-center mt-4 feedback-container">
                    <a href="myOrders.php" class="btn btn-outline-secondary">← Back to Orders</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
