<?php
    session_start();
    include('../includes/dbconn.php');
    $isRole = isset($_SESSION['role']);
    $role = $isRole ? $_SESSION['role'] : '';
  

    $isLoggedIn = isset($_SESSION['name']);
    $Name = $isLoggedIn ? $_SESSION['name'] : '';
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $select = "select * from users Where email='$email'";
        $result = mysqli_query($dbconn, $select);
        
        
        if (mysqli_num_rows($result) === 0) {
          $_SESSION['error'] = "Email not found.";
        } else {
          $rowData = mysqli_fetch_assoc($result);
          $hashedPassword= $rowData['password'];
          $role_check = $rowData['role'];
          if (password_verify($password, $hashedPassword)) {
            if ($role == "admin" && $role_check=="admin"){
                $_SESSION['user_id']=$rowData['id'];
                $_SESSION['name']=$rowData['FULL_name'];
                $_SESSION['role']=$rowData['role'];
                
                header("Location: admin_main.php?id= {$rowData['id']}");
                exit;
            }
            elseif ($role == "student" && $role_check=="student"){
                $_SESSION['user_id']=$rowData['id'];
                $_SESSION['name']=$rowData['FULL_name'];
                $_SESSION['role']=$rowData['role'];
              header("Location: student_main.php?id= {$rowData['id']}");
              exit;
            }
            else {
               $_SESSION['error'] = "Selected role does not match our records.";
            }
            
          }
          else {
              $_SESSION['error'] = "Incorrect password.";
              // header("Location: login.php");
          }
        }
        
        
    }
    $error = "";
    // If an error was stored in session, retrieve and clear it
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sunway Canteen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">
  <link href="../css/theme.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nova+Cut&display=swap" rel="stylesheet">
  
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
                  <span class="nav-link nochange">Hi there, <?= htmlspecialchars($Name) ?>!</span>
              </li>
          <?php endif; ?>
              
          
          <li class="nav-item">
              <a class="nav-link active" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= $isLoggedIn ? ($role === 'admin' ? 'admin_main.php' : 'student_main.php') : 'login.php' ?>">Menu</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= $isLoggedIn ? ($role === 'admin' ? 'admin_main.php' : 'student_main.php') : 'login.php' ?>">Orders</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    
  <div class="log-in">
    <div class="login-main">
      <h2>Login</h2>
      <form action="login.php" method="POST">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>
        <div class="mb-3">
          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-4">
          <label for="role">Login as:</label>
          <select name="role" class="form-select" required>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <input type="submit" value="Login" class="btn btn-primary">
      </form>

      <div class="mt-3 text-center">
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        <p>Forgot your password? <a href="forget_password.php">Reset it here</a></p>
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
