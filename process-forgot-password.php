<?php
require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists in users table
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(32));
        $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour

        // Store token in users table
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires_at, $email);
        $stmt->execute();

        // Send email with reset link
        $reset_link = "http://yourwebsite.com/reset-password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: " . $reset_link;
        $headers = "From: no-reply@yourwebsite.com\r\n";

        mail($email, $subject, $message, $headers);

        echo "✅ A password reset link has been sent to your email.";
    } else {
        echo "❌ Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
