<?php
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ? AND email_verified = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update email verification status
        $stmt = $conn->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "✅ Your email has been verified! You can now <a href='login.html'>log in</a>.";
    } else {
        echo "⚠️ Invalid or expired verification link!";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "⚠️ No verification token provided!";
}
?>
