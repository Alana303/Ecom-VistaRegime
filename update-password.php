<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        header("Location: reset-password.php?token=".$_POST['token']);
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

    // Update user password
    $query = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();

    // Delete the reset token
    $deleteQuery = "DELETE FROM password_resets WHERE email = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $_SESSION['message'] = "Password updated successfully. You can now log in.";
    header("Location: login.php");
    exit();
}
?>
