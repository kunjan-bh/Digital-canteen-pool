<?php
    session_start();
    include('../includes/dbconn.php');
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    $current_menu_id = $_GET['menu_itemId'];
    $select = "Select * from menu_items Where id= '$current_menu_id'";
    $result = mysqli_query($dbconn, $select);
    $rowData = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $uploadDir = '../uploads/';
        $uploadPath = $uploadDir . basename($imageName);
        if(!empty($imageName)){
            if (move_uploaded_file($imageTmp, $uploadPath)) {
                $update = "UPDATE menu_items SET name = '$name', category_id = '$category_id', price = '$price', description = '$description', image_path = '$imageName' WHERE id = '$current_menu_id'";
                mysqli_query($dbconn, $update);
                header("Location: admin_main.php");
        

            } else {
                echo "Image upload failed.";
            }
        }
        else {
            $update = "UPDATE menu_items SET name = '$name', category_id = '$category_id', price = '$price', description = '$description' WHERE id = '$current_menu_id'";
            mysqli_query($dbconn, $update);
            header("Location: admin_main.php");
        }

        
       
        
        

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="editItemBody">
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
            <h2 class="mb-4 text-center font-custom">Edit Menu Item</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Item Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $rowData['name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category_id" class="form-select" value="<?php echo $rowData['category_id']; ?>" required>
                        <option value="">--Select Category--</option>
                        <option value="1" <?= $rowData['category_id'] == 1 ? 'selected' : '' ?>>Beverages</option>
                        <option value="2" <?= $rowData['category_id'] == 2 ? 'selected' : '' ?>>Snacks</option>
                        <option value="3" <?= $rowData['category_id'] == 3 ? 'selected' : '' ?>>Main Course</option>
                        <option value="4" <?= $rowData['category_id'] == 4 ? 'selected' : '' ?>>Bakery Items</option>
                        <option value="5" <?= $rowData['category_id'] == 5 ? 'selected' : '' ?>>Fast Food</option>
                        <option value="6" <?= $rowData['category_id'] == 6 ? 'selected' : '' ?>>Desserts</option>
                        <option value="7" <?= $rowData['category_id'] == 7 ? 'selected' : '' ?>>Specials</option>
                        <option value="8" <?= $rowData['category_id'] == 8 ? 'selected' : '' ?>>Vegan</option>
                        <option value="9" <?= $rowData['category_id'] == 9 ? 'selected' : '' ?>>Non-Vegetarian</option>
                        <option value="10" <?= $rowData['category_id'] == 10 ? 'selected' : '' ?>>Breakfast</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (NPR):</label>
                    <input type="number" step="10" name="price" class="form-control" value="<?php echo $rowData['price']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" rows="4" class="form-control"><?php echo $rowData['description']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" name="image" accept="image/*" class="form-control">
                </div>

                <div class="text-center">
                    <input type="submit" value="Update Item" class="btn btn-primary">
                </div>
            </form>
            <div class="text-left">
                <a href="admin_main.php" class="btn btn-outline fw-bold back-btn">← Back</a>
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
