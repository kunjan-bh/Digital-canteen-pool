<?php 
    session_start();
    include('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $menu_id = $_GET['menu_id'];
    $user_id = $_GET['user_id'];
    // echo $menu_id;
    $select = "select * from menu_items where id = '$menu_id'";
    $result = mysqli_query($dbconn, $select);
    $rowData = mysqli_fetch_assoc($result);
    // echo $rowData['name'];  
    $item_name = $rowData['name'];
    $item_price = $rowData['price'];
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $quantity = $_POST['quantity'];
        $method = $_POST['payMethod'];
        $total = (int) ((int)$quantity * (int)$rowData['price']);
        $insert_order = "insert into orders (user_id, total_price, status, pay_method) values('$user_id','$total', 'Pending', '$method')";
        
        if (mysqli_query($dbconn, $insert_order))
        {
            $order_id = mysqli_insert_id($dbconn);
            $insert_order_items = "insert into order_items (order_id, item_id, quantity) values('$order_id', '$menu_id', '$quantity')";
            if(mysqli_query($dbconn, $insert_order_items)){
                $history= "insert into food_history (user_id, item_id, item_name, price_per_quantity, quantity) values ('$user_id', '$menu_id', '$item_name', '$item_price', '$quantity')";
                mysqli_query($dbconn, $history);
                echo "Item added to cart successfully!";
                header("Location: student_main.php");
            }

            
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Food</title>
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
                <a class="nav-link active" href="<?= $isLoggedIn ? 'admin_main.php' : 'login.php' ?>">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $isLoggedIn ? 'allOrders.php' : 'login.php' ?>">Orders</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Selected Food Item</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($rowData['name']) ?></h5>
                        <p class="card-text"><strong>Price per Quantity:</strong> Rs. <?= htmlspecialchars($rowData['price']) ?></p>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="payMethod" class="form-label">Payment Method</label>
                                <select name="payMethod" class="form-select" required>
                                    <option value="">--Select--</option>
                                    <option value="Cash">Cash</option>
                                    <option value="esewa">Esewa</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Add</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4 mb-5">
                    <a href="student_main.php" class="btn btn-outline fw-bold back-btn white">← Back to Dashboard</a>
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
