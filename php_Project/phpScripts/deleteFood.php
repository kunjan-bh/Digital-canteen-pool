<?php
    include ('../includes/dbconn.php');
    $menu_id = $_GET['menu_itemId'];
    $delete_order_items = "DELETE FROM order_items WHERE item_id = '$menu_id'";
    mysqli_query($dbconn, $delete_order_items);

    
    $delete_menu_item = "DELETE FROM menu_items WHERE id = '$menu_id'";
    mysqli_query($dbconn, $delete_menu_item);
    header("Location: admin_main.php");
?>