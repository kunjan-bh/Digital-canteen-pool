<?php
session_start();
include '../includes/dbconn.php';

if (!isset($_SESSION['email'])) {
    header("Location: forget_password.php");
    exit();
}

$error = "";

$user_id = $_SESSION['user_id'];
echo $user_id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass = $_POST['password'];
    $cpass = $_POST['confirm_password'];

    if ($pass !== $cpass) {
        $error = "Passwords do not match.";
    } else {
        $email = $_SESSION['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($dbconn, $sql);
        
        // $result = $conn->query("SELECT id FROM users WHERE email = '$email'");

        if ($result && $result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = (int)$row['id'];
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET password = '$hash' WHERE id = $user_id";
            if (mysqli_query($dbconn, $sql)) {
                session_destroy();
                header("Location: login.php");
                exit();
            } else {
                $error = "Failed to update password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Canteen Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
</head>
<body class="bg-light pass-correct">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="card-title text-center mb-3">Reset Your Password</h4>
            <form method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>

            <?php if ($error): ?>
                <div class="alert alert-danger mt-3" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
