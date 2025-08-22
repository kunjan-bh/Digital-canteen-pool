<?php
    include('../includes/dbconn.php');
    $order_id = $_GET['order_id'];
    $sql = "update orders set payment = 'Paid' where id ='$order_id'"; 
    mysqli_query($dbconn, $sql);
    header('Location: allorders.php');
?>