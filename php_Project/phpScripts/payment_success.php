<?php
    session_start();
    include ('../includes/dbconn.php');
    $order_id = $_GET['order_id'];
    
    $sql = "UPDATE orders SET payment = 'Paid' WHERE id ='$order_id'"; 
    mysqli_query($dbconn, $sql);
    // header('Location: myOrders.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="text-center bg-white p-5 rounded shadow" style="max-width: 400px; width: 100%;">
        <h1 class="text-success mb-4">Payment Successful</h1>
        <p class="mb-4">Thank you for your purchase!</p>
        <a href="myOrders.php" class="btn btn-success">Back to My Orders</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
