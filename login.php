<?php
session_start();
include 'config.php'; // Your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            echo "✅ Login successful!";
        } else {
            echo "❌ Incorrect password. Try again!";
        }
    } else {
        echo "❌ No account found with this email!";
    }
}
?>
