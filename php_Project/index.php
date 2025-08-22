<?php
session_start();

// Simulating a logged-in user (for demonstration)
// $_SESSION['first_name'] = "Ram"; // Uncomment this to test logged-in view

$isLoggedIn = isset($_SESSION['name']);
$Name = $isLoggedIn ? $_SESSION['name'] : '';
$isRole = isset($_SESSION['role']);
$role = $isRole ? $_SESSION['role'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sunday Canteen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <link href="css/main.css" rel="stylesheet">
    
</head>
<body>
    
    <div class="landing">
        <div class="shape1"></div>
        <div class="shape2"></div>
        <div class="shape3"></div>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
            <div class="container">
            <a class="navbar-brand" href="index.php">SUNWAYFOOD</a>
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
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $isLoggedIn ? ($role === 'admin' ? 'phpScripts/admin_main.php' : 'phpScripts/student_main.php') : 'phpScripts/login.php' ?>">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $isLoggedIn ? ($role === 'admin' ? 'phpScripts/allOrders.php' : 'phpScripts/myOrders.php') : 'phpScripts/login.php' ?>">Orders</a>
                </li>
                </ul>
            </div>
            </div>
        </nav>
        <main class="land-main">

            
            <div class="container alternate0">
                <div class="row">
                    <div class="col text-block">
                        <h1 class="fw-bold">NOW OPENING</h1>
                        <h2 class="fw-bold highlight">Digital Canteen Pool</h2>
                        <h5 class="fw-bold">Sunway College, Maitidevi</h5>
                        <p class="text">A digital canteen experience like no other. Order, explore, and enjoy your favorites every Sunday — all from one place. Whether you're a student, staff, or visitor, the Sunday Canteen is your quick stop to great food and good vibes.</p>
                        <a href="<?= $isLoggedIn ? ($role === 'admin' ? 'phpScripts/admin_main.php' : 'phpScripts/student_main.php') : 'phpScripts/login.php' ?>" class="btn btn-custom">Get Started!</a>
                    </div>
                    <div class="col img-container">
                        <img src="image/mix.png" alt="Dish 1" class="img-landing">
                    <!-- <img src="image/mix.png" alt="Dish 2" class="img-fluid1 custom-shape" width="500" height="400"> -->
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
            
        </main>
        
    </div>
    

  

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

