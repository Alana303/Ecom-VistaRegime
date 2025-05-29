<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send reset link to email
        $resetLink = "http://localhost/ecomvista/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password: \n\n$resetLink";
        $headers = "From: no-reply@ecomvista.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "📩 A password reset link has been sent to your email!";
        } else {
            echo "❌ Failed to send email!";
        }
    } else {
        echo "⚠️ No account found with this email!";
    }

    $stmt->close();
    $conn->close();
}
?>
