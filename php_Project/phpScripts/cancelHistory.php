<?php
    include ('../includes/dbconn.php');
    $orderHistory_id = intval($_GET['id']); 
    $deleteHistory = "DELETE FROM food_history WHERE id = '$orderHistory_id'";
    mysqli_query($dbconn, $deleteHistory);

    header("Location: orderHistory.php");
?>
