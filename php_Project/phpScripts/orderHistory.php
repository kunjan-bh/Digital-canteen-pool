<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $student_id = $_SESSION['user_id'];

    $select ="select * from food_history where user_id ='$student_id'";
    $result = mysqli_query($dbconn, $select);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History list</title>
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
      <h1 class="fw-bold display-5">📦 Order History</h1>
      <h5 class="fw-semibold" >Food Purchase History</h5>
      <hr class="w-25 mx-auto" style="border-top: 3px solid #fff;">
  </div>
  <div class="container mt-5">

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="accordion" id="foodHistoryAccordion">
        <?php $index = 0; while ($row = mysqli_fetch_assoc($result)): ?>
          <?php $collapseId = "collapse" . $index; ?>
          <div class="accordion-item mb-5">
            <h2 class="accordion-header" id="heading<?= $index ?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
                <div class="accordion-button-content">
                  <span class="item-name"><?= htmlspecialchars($row['item_name']) ?></span>
                  <span class="item-qty">Qty: <?= $row['quantity'] ?></span>
                </div>
              </button>
            </h2>
            <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#foodHistoryAccordion">
              <div class="accordion-body">
                <p><strong>Item ID:</strong> <?= $row['item_id'] ?></p>
                <p><strong>Price per Quantity:</strong> ₹<?= $row['price_per_quantity'] ?></p>
                <p><strong>Purchase Time:</strong> <?= $row['purchase_time'] ?></p>
                <a href="cancelHistory.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Cancel</a>
              </div>
            </div>
          </div>
        <?php $index++; endwhile; ?>
      </div>
    <?php else: ?>
      <div class="text-center mt-5">
        <h4 class="text-danger">No Orders History Found</h4>
        <p class="text-muted">You haven't purchased any food yet.</p>
      </div>
      <div style="height: 200px;"></div>
    <?php endif; ?>
    <div class="text-center mt-4 feedback-container">
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
