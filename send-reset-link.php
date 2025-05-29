<?php
session_start();
include 'config.php';
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Generate secure token
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expiry

        // Store token in database
        $insertQuery = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Replace with SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@example.com'; // SMTP username
            $mail->Password = 'your-email-password'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('no-reply@example.com', 'EcomVista');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "Click the link below to reset your password: \n\n http://yourwebsite.com/reset-password.php?token=$token";

            $mail->send();
            $_SESSION['message'] = "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            $_SESSION['message'] = "Error sending email. Try again later.";
        }
    } else {
        $_SESSION['message'] = "No account found with this email.";
    }
    
    header("Location: forgot-password.php");
    exit();
}
?>
