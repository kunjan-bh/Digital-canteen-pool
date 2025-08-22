<?php 
    session_start();
    include('../includes/dbconn.php');
    
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $select = "select * from menu_items";
    $result = mysqli_query($dbconn, $select);

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $uploadDir = '../uploads/';
        $uploadPath = $uploadDir . basename($imageName);

        $select = "select * from menu_items where name = '$name'";
        $result = mysqli_query($dbconn, $select);
        if (mysqli_num_rows($result) > 0){
            header("Location: add.php");
        } 
        if (move_uploaded_file($imageTmp, $uploadPath)){
            $insert = "insert into menu_items(name, category_id, price, description, image_path) values('$name', '$category_id', '$price', '$description', '$imageName')";
            mysqli_query($dbconn, $insert);
            header("Location: admin_main.php");
        }
        

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="addItemBody">
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
    <div class="container my-5">
        <div class="card shadow-lg p-4 main-div-form">
            <h2 class="mb-4 text-center font-custom">Add New Menu Item</h2>
            <form action="add.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">--Select Category--</option>
                        <option value="1">Beverages</option>
                        <option value="2">Snacks</option>
                        <option value="3">Main Course</option>
                        <option value="4">Bakery Items</option>
                        <option value="5">Fast Food</option>
                        <option value="6">Desserts</option>
                        <option value="7">Specials</option>
                        <option value="8">Vegan</option>
                        <option value="9">Non-Vegetarian</option>
                        <option value="10">Breakfast</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (NPR)</label>
                    <input type="number" name="price" class="form-control" step="10" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control">
                </div>

                <div class="text-center">
                    <input type="submit" value="Add Item" class="btn btn-warning px-4 py-2 text-white fw-bold">
                </div>
                <div class="text-left">
                    <a href="admin_main.php" class="btn btn-outline fw-bold back-btn">← Back</a>
                </div>
            </form>
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
