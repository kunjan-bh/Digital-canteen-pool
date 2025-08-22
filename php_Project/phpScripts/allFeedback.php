<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $student_id = $_SESSION['user_id'];
    $select_query = "select f.id as id, f.user_id as userId, f.order_id as orderId, f.message as msg, f.rating as rating, mi.name as item_name  FROM feedback f join orders o on f.order_id=o.id join order_items oi on o.id=oi.order_id join menu_items mi on oi.item_id= mi.id";
    $result = mysqli_query($dbconn, $select_query);
    $number = mysqli_num_rows($result);
    // echo $student_id;
    function renderStars($rating) {
    $stars = str_repeat('⭐', intval($rating));
    $empty = str_repeat('☆', 5 - intval($rating));
    return $stars . $empty;

    }
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
        <h1 class="fw-bold display-5">📦 All Feedbacks</h1>
        <h5 class="fw-semibold" >Food Reviews</h5>
        <hr class="w-25 mx-auto" style="border-top: 3px solid #fff;">
    </div>
    <?php
    echo $number;
    ?>
    
    <div class="container mb-5 feedback-container">
        <div class="accordion" id="feedbackAccordion">
            <?php 
            $count = 1;
            if (mysqli_num_rows($result)>0):
            while ($row = mysqli_fetch_assoc($result)): 
                $accordionId = 'feedback' . $count;
            ?>
                <div class="accordion-item border border-dark">
                    <h2 class="accordion-header" id="heading<?= $accordionId ?>">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $accordionId ?>" aria-expanded="false" aria-controls="collapse<?= $accordionId ?>">
                            <div>
                                <div>Order #<?= htmlspecialchars($row['orderId']) ?> - <?= htmlspecialchars($row['item_name']) ?></div>
                                <div class="text-warning small"><?= renderStars($row['rating']) ?> (<?= $row['rating'] ?>/5)</div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?= $accordionId ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $accordionId ?>" data-bs-parent="#feedbackAccordion">
                        <div class="accordion-body">
                            <p><strong>User ID:</strong> <?= htmlspecialchars($row['userId']) ?></p>
                            <p><strong>Message:</strong> <?= htmlspecialchars($row['msg']) ?></p>
                            <div class="text-end">
                                <a href="cancelFeed.php?feedId=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Cancel Feedback</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            $count++;
            endwhile; 
            else:

            ?>
            <div class="text-center mt-5">
                <h3 class="text-danger">No feedbacks</h3>
                <div style="height: 150px;"></div>
            </div>
            
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="admin_main.php" class="btn btn-secondary">← Back to Dashboard</a>
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