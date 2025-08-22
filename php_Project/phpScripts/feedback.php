
<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $student_id = $_SESSION['user_id'];
    $select_query = "SELECT o.id AS order_id, o.order_time, o.total_price, o.status, mi.name AS food_name, oi.quantity FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN menu_items mi ON oi.item_id = mi.id WHERE o.user_id = $student_id AND o.status = 'Ready' ORDER BY o.order_time;";
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
                <a class="nav-link" href="<?= $isLoggedIn ? 'allOrders.php' : 'login.php' ?>">Orders</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="text-center py-4 order-head mb-5" style="background: linear-gradient(to right, #4B1D1D, #1a1a1a); color: #ffcc99;">
        <h1 class="fw-bold display-5"> My Feedbacks</h1>
        <h4 class="fw-semibold"> Give reviews to the foods</h4>
        <hr class="w-25 mx-auto" style="border-top: 3px solid #fff;">
    </div>

    
    <div class="container mt-5 self-feedback mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Your Orders</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Food Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(mysqli_num_rows($result)>0){
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td data-label='Order ID'>{$row['order_id']}</td>
                                <td data-label='Order Time'>". date('Y-m-d', strtotime($row['order_time'])) ."</td>
                                <td data-label='Food Name'>{$row['food_name']}</td>
                                <td data-label='Quantity'>{$row['quantity']}</td>
                                <td data-label='Total Price'>{$row['total_price']}</td>
                                <td data-label='Action'>
                                    <a href='writeFeed.php?order_id={$row['order_id']}&user_id={$student_id}&food_n={$row['food_name']}' class='btn btn-sm btn-outline-primary'>
                                        Give Feedback
                                    </a>
                                </td>
                            </tr>";
                    }
                }else{
                    echo "<tr><td colspan='6'>No Orders for feedback</td></tr>";
                }
                    ?>
                    </tbody>
                </table>
                <div class="text-center mt-4 mb-3">
                    <a href="student_main.php" class="btn btn-outline-secondary">← Back to Dashboard</a>
                </div>
            </div>
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