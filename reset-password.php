<?php
require 'config.php'; // Database connection

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($email);
        $stmt->fetch();
    } else {
        die("❌ Invalid or expired token.");
    }
} else {
    die("❌ No token provided.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    // Update user's password
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    $stmt->execute();

    echo "✅ Password successfully reset! <a href='login.html'>Login here</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="forgot-password.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Set New Password</h2>
        <form action="" method="POST">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
