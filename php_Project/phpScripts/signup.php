<?php
    session_start();
    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    include('../includes/dbconn.php');
    $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'admin'";
    $rowdata= mysqli_fetch_assoc(mysqli_query($dbconn, $sql));
    
    
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        if ($role== "admin"){
          if($rowdata['total']>1){
            $_SESSION['error'] = "Admins are already present.";
            header("Location: signup.php");
            exit;
          }
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // $checkUser = mysqli_query($dbconn, "SELECT * FROM users WHERE username = '$username'");
        $checkEmail = mysqli_query($dbconn, "SELECT * FROM users WHERE email = '$email'");

        if (mysqli_num_rows($checkEmail) > 0) {
             $_SESSION['error'] = "Email already registered.";
             header("Location: signup.php");  // Redirect back to form
          exit;
        }
        else {
          $cus_query = "insert into users (full_name, email, password, role) values ('$name', '$email', '$hashed_password', '$role')";
          $result = mysqli_query($dbconn, $cus_query);
          mysqli_close($dbconn);
          header("Location: login.php");
        }
       
    }
    $error = '';
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);  // Clear error after loading it
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up - Sunway Canteen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">
  <link href="../css/theme.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">

  

</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
    <div class="container">
      <a class="navbar-brand" href="../index.php">SUNWAYFOOD</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
              
          <?php if ($isLoggedIn): ?>
              <li class="nav-item">
                  <span class="navlink nochange">Hi there, <?= htmlspecialchars($Name) ?>!</span>
              </li>
          <?php endif; ?>
              
          
          <li class="nav-item">
              <a class="nav-link active" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= $isLoggedIn ? 'menu.php' : 'login.php' ?>">Menu</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= $isLoggedIn ? 'menu.php' : 'login.php' ?>">Orders</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="log-in">
    <div class="login-main">
      <h2>Sign Up</h2>
      <form action="#" method="POST">
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
          <label for="name">Full Name:</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-4">
          <label for="role">Signup as:</label>
          <select name="role" class="form-select" required>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <input type="submit" value="Signup" class="btn btn-primary">
      </form>

      <div class="mt-3 text-center">
        <p>Already have an account? <a href="login.php">Log in here</a></p>
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
