<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';
include '../includes/dbconn.php';

session_start();
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = rand(100000, 999999);

    // $stmt = $conn->prepare("SELECT * FROM members WHERE email = ?");
    // $stmt->bind_param("s", $email);
    // $stmt->execute();
    // $result = $stmt->get_result();
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($dbconn, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        $_SESSION['otp'] = $otp;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bhattakunjan10@gmail.com'; // change this
            $mail->Password = 'vuqy bitv doby byfb'; // change this
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Canteen Portal');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: $otp";

            $mail->send();
            header("Location: verify.php");
            exit();
        } catch (Exception $e) {
            $error = "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email address not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Canteen Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
</head>
<body class="bg-light pass-correct">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="card-title text-center mb-3">Forgot Password</h4>
            <p class="text-center text-muted">Enter your email to receive an OTP</p>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <p style="text-align:center; color:red;">The account's Email must be real to reset the password via code</p>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Send OTP</button>
                </div>
            </form>
            <?php if ($error): ?>
                <div class="alert alert-danger mt-3" role="alert"><?= $error ?></div>
            <?php elseif ($success): ?>
                <div class="alert alert-success mt-3" role="alert"><?= $success ?></div>
            <?php endif; ?>
            
            <div class="text-center mt-4">
                <a href="login.php" class="btn btn-outline-secondary">← Back</a>
            </div>
        </div>
        
    </div>
</body>
</html>


