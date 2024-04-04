<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
      body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        section {
            height: 100%;
            width: 100%;
            position: absolute;
            background: radial-gradient(#333, #000);
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.5);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            max-width: 400px; /* Adjust the maximum width */
            width: 80%; /* Adjust the width as needed */
            height: 450px; /* Increase the height */
            overflow-y: auto; /* Add scrollbar if needed */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the transparency */
        }

        .form-btn {
            text-align: center;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 15px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <section></section> <!-- Add this section -->
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
           if ($user) {
               if (password_verify($password, $user["password"])) {
                   session_start();
                   $_SESSION["user"] = "yes";
                   header("Location: web.html");
                   exit; // Added exit to prevent further execution
               } else {
                   echo "<div class='alert alert-danger'>Password does not match</div>";
               }
           } else {
               echo "<div class='alert alert-danger'>Email does not match</div>";
           }
        }
        ?>
        <form action="login.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" id="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
        <div><p><a href="forgot_password.php">Forgot Password?</a></p></div> <!-- Added Forgot Password link -->
    </div>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            
            if (email.trim() === "") {
                alert("Please enter your email.");
                return false;
            }
            
            if (password.trim() === "") {
                alert("Please enter your password.");
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
