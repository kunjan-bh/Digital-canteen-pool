<?php
    include('../includes/dbconn.php');
    $order_id = $_GET['order_id'];
    $status = $_GET['b'];
    $update="UPDATE orders SET status = '$status' Where id = $order_id";
    $result = mysqli_query($dbconn, $update);
    header("Location: allOrders.php");
?>