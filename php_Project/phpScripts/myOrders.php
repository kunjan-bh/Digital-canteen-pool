<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $student_id = $_SESSION['user_id'];
    $select_query = "SELECT o.id AS order_id,mi.id as item_id, o.order_time, o.total_price, o.status, o.pay_method, o.payment, mi.name AS food_name, oi.quantity FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN menu_items mi ON oi.item_id = mi.id WHERE o.user_id = $student_id ORDER BY o.order_time;";
    $result = mysqli_query($dbconn, $select_query);
    // echo $student_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My order list</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">

</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 main-page-nav">
        <div class="container">
        <a class="navbar-brand" href="../index.php">SUNWAYFOOD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
        <?php if ($isLoggedIn): ?>
            <li class="nav-item">
                <span class="nav-link nochange">Hi there, <?= htmlspecialchars($Name) ?>!</span>
            </li>
        <?php endif; ?>
                
            
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $isLoggedIn ? 'admin_main.php' : 'login.php' ?>">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= $isLoggedIn ? 'allOrders.php' : 'login.php' ?>">Orders</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="text-center py-4 order-head mb-5" style="background: linear-gradient(to right, #4B1D1D, #1a1a1a); color: #ffcc99;">
        <h1 class="fw-bold display-5">📦 Order List</h1>
        <h5 class="fw-semibold" >Order Management</h5>
        <hr class="w-25 mx-auto" style="border-top: 3px solid #fff;">
    </div>
    
    <div class="container mb-5">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm card-left-style">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <strong><?= htmlspecialchars($row['food_name']) ?></strong>
                                    <span class="badge bg-secondary float-end">x<?= $row['quantity'] ?></span>
                                </h5>
                                <p class="card-text"><strong>Order ID:</strong> <?= $row['order_id'] ?></p>
                                <p class="card-text"><strong>Time:</strong> <?= $row['order_time'] ?></p>
                                <p class="card-text"><strong>Total Price:</strong> Rs. <?= $row['total_price'] ?></p>
                                <p class="card-text"><strong>Payment Method:</strong> <?= ucfirst($row['pay_method']) ?></p>

                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <span class="badge <?= $row['payment'] == 'Paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                        <?= $row['payment'] ?>
                                    </span>
                                    <span class="badge 
                                        <?php 
                                            if ($row['status'] == 'Delivered') echo 'bg-success';
                                            elseif ($row['status'] == 'Ready') echo 'bg-info text-dark';
                                            elseif ($row['status'] == 'Preparing') echo 'bg-primary';
                                            else echo 'bg-secondary';
                                        ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="card-footer bg-white border-0 d-flex justify-content-between">
                                <?php if (($row['payment']=='Not Paid' && ($row['status']=='Ready' || $row['status']=='Preparing')) || ($row['payment']=='Paid' && $row['status']=='Preparing')): ?>
                                    <button class="btn btn-outline-secondary btn-sm" disabled>Cancel</button>
                                <?php else: ?>
                                    <a href="cancelOrder.php?order_id=<?= $row['order_id'] ?>&item_id=<?= $row['item_id'] ?>" class="btn btn-outline-danger btn-sm">Cancel</a>
                                <?php endif; ?>

                                <?php if ($row['pay_method'] == 'esewa' && $row['payment'] == 'Not Paid'): ?>
                                    <a href="pay.php?order_id=<?= $row['order_id'] ?>&food_name=<?= urlencode($row['food_name']) ?>&price=<?= $row['total_price'] ?>" class="btn btn-success btn-sm">Pay Now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No orders found.</p>
            <div style="height: 200px;"></div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="student_main.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
        </div>
    </div>
    <div class="alternate">
        <div class="container">
            <div class="row">
                <div class="col hr">
                    <hr style="border: none; height: 4px; background-color:rgb(255, 255, 255);">
                </div>
                <div class="col quote">
                    <div class="quote-box text-center my-3">
                        <blockquote class="blockquote">
                            <p class="mb-0">“Good food is the foundation of genuine happiness — where every bite tells a story, and every Sunday becomes a memory.”</p>
                        </blockquote>
                    </div>
                </div>
                <div class="col hr">
                    <hr style="border: none; height: 4px; background-color:rgb(255, 255, 255);">
                </div>
            </div>
        </div>
    </div>



</body>
</html>