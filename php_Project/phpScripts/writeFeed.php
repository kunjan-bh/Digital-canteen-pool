<?php 
    session_start();
    include('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $order_id = $_GET['order_id'];
    $user_id = $_GET['user_id'];
    $food_n= $_GET['food_n'];
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $message = $_POST['message'];
        $rating = $_POST['rating'];
        $insert = "insert into feedback (user_id, order_id, message, rating) values('$user_id', '$order_id', '$message', '$rating')";
        $result= mysqli_query($dbconn, $insert);
        header("Location: feedback.php");//for giving feedback once per food order
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">

</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <div class="writeFeed">
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
        <!-- Feedback Form Section -->
        <div class="container my-5" style="min-height: 250px;">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0 text-center">Submit Your Feedback for <?= htmlspecialchars($food_n) ?></h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message:</label>
                                    <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating (1 to 5):</label>
                                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
                                </div>

                                <div class="d-grid">
                                    <input type="submit" value="Submit Feedback" class="btn btn-primary">
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-2 mb-4">
            <a href="feedback.php" class="btn btn-outline-secondary">← Back</a>
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
    </div>
</body>
</html>
