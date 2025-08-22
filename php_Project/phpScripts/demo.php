
<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $student_id = $_SESSION['user_id'];
    $select_query = "SELECT o.id AS order_id, o.order_time, o.total_price, o.status, mi.name AS food_name, oi.quantity FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN menu_items mi ON oi.item_id = mi.id WHERE o.user_id = $student_id AND o.status = 'Ready' ORDER BY o.order_time;";
    $result = mysqli_query($dbconn, $select_query);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media (max-width: 768px) {
            table thead {
                display: none;
            }
            table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                padding: 1rem;
                background: #f8f9fa;
            }
            table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0;
                border: none;
                border-bottom: 1px solid #dee2e6;
            }
            table tbody td:last-child {
                border-bottom: none;
            }
            table tbody td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #333;
            }
        }
    </style>
</head>
<body>



<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
