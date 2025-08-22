<?php
    session_start();
    include ('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    // echo $_SESSION['name'];

    if($_SERVER['REQUEST_METHOD']=='POST'){
      $category= $_POST['category_select'];
      if ($category == 'all'){
        $select = "SELECT mi.id, mi.name, mi.category_id, mi.price, mi.description, mi.image_path, c.name as categoryName FROM menu_items mi join categories c on c.id= mi.category_id";
        
      } else {
        $select = "SELECT mi.id, mi.name, mi.category_id, mi.price, mi.description, mi.image_path, c.name as categoryName FROM menu_items mi join categories c on c.id= mi.category_id where c.name ='$category'";
      }
      
      
      
    }else {
      $select = "SELECT mi.id, mi.name, mi.category_id, mi.price, mi.description, mi.image_path, c.name as categoryName FROM menu_items mi join categories c on c.id= mi.category_id";
    }
    // $result= mysqli_query($dbconn, $select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Sunway Canteen</title>
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
  <div class="admin_menu_main">
    <div class="text-center py-4" style="background: linear-gradient(to right, #4B1D1D, #1a1a1a); color: #ffcc99;">
        <h1 class="mb-0" style="font-weight: bold;">Welcome to Sunway Canteen</h1>
        <p class="text-light">Admin Menu Dashboard</p>
    </div>
    <div class="container mt-4">
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

      <div class="d-flex justify-content-between align-items-center my-4">
        <div class="nav-links">
          <a href="allOrders.php" class="btn btn-outline-primary me-2">ALL Orders</a>
          <a href="allFeedback.php" class="btn btn-outline-secondary">Feedbacks</a>
        </div>
        <a href="Add.php" class="btn btn-success">+ Add Food</a>
      </div>

      <h2 class="mb-3">Menu Items</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php
      // $select = "SELECT mi.id, mi.name, mi.category_id, mi.price, mi.description, mi.image_path, c.name as categoryName FROM menu_items mi join categories c on c.id= mi.category_id";
      $result = mysqli_query($dbconn, $select);
      if (mysqli_num_rows($result) > 0){
      while ($rowData = mysqli_fetch_assoc($result)) {
      ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="../uploads/<?= htmlspecialchars($rowData['image_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($rowData['name']) ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h4 class="card-title"><?= htmlspecialchars($rowData['name']) ?></h5>
              <p class="card-text mb-1"><strong>Category:</strong> <?= htmlspecialchars($rowData['categoryName']) ?></p>
              <p class="card-text mb-1"><strong>Price:</strong> Rs. <?= htmlspecialchars($rowData['price']) ?></p>
              <p class="card-text"><strong>Description:</strong> <?= nl2br(htmlspecialchars($rowData['description'])) ?></p>
              <div class="mt-auto d-flex justify-content-between">
                <a href="editFood.php?menu_itemId=<?= $rowData['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="deleteFood.php?menu_itemId=<?= $rowData['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      }else {
      ?>
      <div class="col-12 text-center">
        <div class="alert alert-warning w-100" role="alert">
          No menu items found in this category.
        </div>
      </div>
      <?php
      }
      ?>
      </div>


      <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-outline-danger logout-btn">Logout</a>
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
  </div>
  

</body>
</html>
