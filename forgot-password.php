<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | EcomVista</title>
    <link rel="stylesheet" href="forgot-password.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Reset Your Password</h2>
        <p>Enter your email address below and we’ll send you a link to reset your password.</p>

        <form action="process-forgot-password.php" method="POST">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <button type="submit">Send Reset Link</button>
        </form>

        <p class="back-to-login"><a href="login.html">Back to Login</a></p>
    </div>

    <script>
        $(document).ready(function(){
            $("#forgotPasswordForm").submit(function(event){
                event.preventDefault(); // Prevent page reload

                var email = $("#email").val();

                $.ajax({
                    url: "send_reset_email.php",
                    type: "POST",
                    data: {email: email},
                    success: function(response) {
                        $("#message").html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>

