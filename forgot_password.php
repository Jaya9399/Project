<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            color: white; /* Set default font color to white */
        }

        section {
            height: 100%;
            width: 100%;
            position: absolute;
            background: radial-gradient(#333, #000);
            z-index: -1; /* Ensure section is behind other content */
        }

        .container {
            position: relative; /* Change position to relative */
            z-index: 1; /* Ensure container is above section */
        }

        /* Custom styles for text field */
        .form-control {
            color: black; /* Change font color to black */
            border-color: black; /* Change border color to black */
        }
    </style>
</head>
<body>
    <section></section>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
require_once "database.php";
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Handle form submission here
if (isset($_POST['submit'])) {
    // Retrieve email from form
    $email = $_POST['email'];

    // Validate the email address (you can add more validation if needed)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email address.</div>";
    } else {
        // Prepare the SQL statement
        $sql = "INSERT INTO reset_tokens (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            // Generate a random token for password reset (you can use any method to generate a token)
            $token = bin2hex(random_bytes(32));

            // Set the expiration time for the token (e.g., 1 hour from now)
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $email, $token, $expires_at);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Send the reset link via email using PHPMailer
                $subject = "Password Reset Link";
                $message = "Click the following link to reset your password: <a href='http://localhost/reset_password.php?token=$token'>Reset Password</a>";

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@gmail.com'; // Replace with your Gmail address
                    $mail->Password = 'your_email_password'; // Replace with your Gmail password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    //Recipients
                    $mail->setFrom('yourname@example.com', 'Your Name');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $message;

                    $mail->send();
                    echo "<div class='alert alert-success'>Reset link has been sent to your email. Please check your inbox.</div>";
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>Failed to send reset link: " . $mail->ErrorInfo . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error occurred while executing the statement: " . mysqli_stmt_error($stmt) . "</div>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Error occurred while preparing the statement: " . mysqli_error($conn) . "</div>";
        }

        // Close the database connection
        mysqli_close($conn);
    }
}
?>





