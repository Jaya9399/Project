<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
            height: auto; /* Adjust the height */
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
        require_once "database.php"; // Include database connection file

        if (isset($_POST["submit"])) {
           $name = $_POST["name"];
           $email = $_POST["email"];
           $message = $_POST["message"];
           $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        

           if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Thank you, $name! We have received your message.</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        }
        ?>
        <form action="" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <input type="text" placeholder="Your Name" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Your Email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <textarea placeholder="Your Message" name="message" id="message" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-btn">
                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var message = document.getElementById("message").value;
            
            if (name.trim() === "") {
                alert("Please enter your name.");
                return false;
            }
            
            if (email.trim() === "") {
                alert("Please enter your email.");
                return false;
            }

            if (message.trim() === "") {
                alert("Please enter your message.");
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
