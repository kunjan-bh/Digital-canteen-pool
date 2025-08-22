<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $student_id = $_SESSION['user_id'];
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $category = $_POST['category_select'];
        if ($category == 'all'){
            $select = "SELECT o.id AS order_id, o.order_time, o.total_price, o.status, o.pay_method, o.payment, mi.name AS food_name, oi.quantity, u.FULL_name as fullName, c.name as category_name FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN menu_items mi ON oi.item_id = mi.id join users u on u.id = o.user_id join categories c on c.id=mi.category_id";
        }else{
            $select = "SELECT o.id AS order_id, o.order_time, o.total_price, o.status, o.pay_method, o.payment, mi.name AS food_name, oi.quantity, u.FULL_name as fullName, c.name as category_name FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN menu_items mi ON oi.item_id = mi.id join users u on u.id = o.user_id join categories c on c.id=mi.category_id where c.name='$category'";
        }
    } else {
        $select = "SELECT o.id AS order_id, o.order_time, o.total_price, o.status, o.pay_method, o.payment, mi.name AS food_name, oi.quantity, u.FULL_name as fullName, c.name as category_name FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN menu_items mi ON oi.item_id = mi.id join users u on u.id = o.user_id join categories c on c.id=mi.category_id";
    
    }
    // echo $student_id;
    $result = mysqli_query($dbconn, $select);
    
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
        <h1 class="fw-bold display-5">📦 All Orders</h1>
        <h5 class="fw-semibold" >Order Management</h5>
        <hr class="w-25 mx-auto" style="border-top: 3px solid #fff;">
    </div>
    


    <div class="container">
        <form action="#" method="POST" class="row g-3 align-items-center mb-4">

            <div class="col-sm-3">
            <select name="category_select" class="form-select" required>
                <option value="" disabled selected>Select a category</option>
                <option value="all">All</option>
                <option value="Beverages">Beverages</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Bakery Items">Bakery Items</option>
                <option value="Snacks">Snacks</option>
                <option value="Main Course">Main Course</option>
                <option value="Fast Food">Fast Food</option>
                <option value="Desserts">Desserts</option>
                <option value="Specials">Specials</option>
                <option value="Vegan">Vegan</option>
                <option value="Non-Vegetarian">Non-Vegetarian</option>
            </select>
            </div>
            <div class="col-sm-4">
            <button type="submit" class="btn btn-primary" style="background-color: orange; color: white; border:none;">Filter Menu</button>
            </div>
        </form>
        <div class="p-3 bg-light rounded shadow-sm mb-4">
            <h5 class="text-dark fw-bold mb-0"><?= mysqli_num_rows($result) ?> orders found</h5>
        </div>
        <div class="row">
            
            <?php 
            
            if (mysqli_num_rows($result)>0){
            while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-primary shadow-sm h-100 p-3">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2">Order ID: <?= $row['order_id'] ?></h5>
                        <h6 class="card-subtitle text-muted mb-3"><?= date("F j, Y, g:i a", strtotime($row['order_time'])) ?></h6>
                        <p><strong>Student:</strong> <?= htmlspecialchars($row['fullName']) ?></p>
                        <p><strong>Food:</strong> <?= htmlspecialchars($row['food_name']) ?> (x<?= $row['quantity'] ?>)</p>
                        <p><strong>Food Category:</strong> <?= $row['category_name'] ?></p>
                        <p><strong>Total Price:</strong> Rs. <?= $row['total_price'] ?></p>
                        <p><strong>Payment Method:</strong> <?= $row['pay_method'] ?></p>
                        <p><strong>Payment Status:</strong> <span class="badge bg-<?= $row['payment'] === 'Paid' ? 'success' : 'secondary' ?>"><?= $row['payment'] ?></span></p>
                        <p><strong>Status:</strong> <span class="badge bg-info"><?= $row['status'] ?></span></p>

                        <div class="mt-auto">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="status.php?order_id=<?= $row['order_id'] ?>&b=Preparing" class="btn btn-warning btn-sm flex-grow-1">Preparing</a>
                                <a href="status.php?order_id=<?= $row['order_id'] ?>&b=Ready" class="btn btn-success btn-sm flex-grow-1">Ready</a>
                                <?php if ($row['pay_method'] == 'Cash'): ?>
                                    <a href="paidByCash.php?order_id=<?= $row['order_id'] ?>" class="btn btn-primary btn-sm flex-grow-1">Paid By Cash</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }}
            else { ?>
            <div class="text-center mt-5">
                <h3 class="text-danger">No Orders</h3>
            </div>
            <div style="height: 250px;"></div>
            <?php
        }
        ?>
        </div>

        
        <div class="text-left mb-4">
            <a href="admin_main.php" class="btn btn-outline fw-bold back-btn white">← Back</a>
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