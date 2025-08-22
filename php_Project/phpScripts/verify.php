<?php
session_start();

$error = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    
    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        $success = "OTP verified successfully.";
        
        header("Location: updatePass.php");
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Canteen Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
</head>
<body class="bg-light pass-correct">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="card-title text-center mb-3">OTP Verification</h4>
            <p class="text-center text-muted">Enter the OTP sent to your email</p>
            <form method="post">
                <div class="mb-3">
                    <label for="otp" class="form-label">Enter OTP</label>
                    <input type="text" class="form-control" name="otp" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Verify OTP</button>
                </div>
            </form>
            <?php if ($error): ?>
                <div class="alert alert-danger mt-3" role="alert"><?= $error ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success mt-3" role="alert"><?= $success ?></div>
            <?php endif; ?>
            <p>The account's Email must be real to reset the password via coede</p>
            <div class="text-center mt-4">
                <a href="forget_password.php" class="btn btn-outline-secondary">← Back</a>
            </div>
        </div>
    </div>
</body>
</html>


