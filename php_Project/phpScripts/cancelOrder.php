<?php
include ('../includes/dbconn.php');
$order_id = intval($_GET['order_id']); 
$item_id = intval($_GET['item_id']); 

$select = "SELECT status FROM orders WHERE id = '$order_id'";
$result = mysqli_query($dbconn, $select);

if ($row = mysqli_fetch_assoc($result)) {
    if ($row['status'] != 'Preparing') {
        // Deleting from feedback at first
        if($row['status'] == 'Pending') {
            $deleteHistory = "DELETE FROM food_history WHERE item_id = '$item_id'";//delete in history too cz the order is not placed
            mysqli_query($dbconn, $deleteHistory);
        }
        $deleteFeedback = "DELETE FROM feedback WHERE order_id = '$order_id'";
        mysqli_query($dbconn, $deleteFeedback);

        //and then deleting from order_items
        $deleteItems = "DELETE FROM order_items WHERE order_id = '$order_id'";
        if (mysqli_query($dbconn, $deleteItems)) {
            //and finally from the parrent table
            $deleteOrder = "DELETE FROM orders WHERE id = '$order_id'";
            mysqli_query($dbconn, $deleteOrder);
        } else {
            header("Location: myOrders.php");
        }
    }
}

header("Location: myOrders.php");
?>
