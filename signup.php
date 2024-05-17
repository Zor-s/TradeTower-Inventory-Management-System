<?php
include './connector.php';
$connector = new connector();


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = strip_tags($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = strip_tags($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];


    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match');</script>";
        echo "<script>window.location.href='./signup.php';</script>";
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $connector->conn->prepare("INSERT INTO customers (customer_id, name, email, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $customer_id, $name, $email, $username, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('User created successfully');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connector->conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="Css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="Css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #007bff, #42d0ff);
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100%;
        }

        .navbar {
            background-color: transparent;
        }

        .navbar .navbar-brand,
        .navbar .navbar-text {
            color: #fff;
            font-size: 24px;
        }

        .navbar .navbar-brand,
        .navbar .navbar-text {
            color: #fff;
            font-size: 28px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="containera">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Inventory</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>
    </div>
    </nav>

    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-4 bg-white rounded p-4">
                <h2 class="text-center">Sign Up Now!</h2>
                <p class="text-center text-muted lead">It's Free and Won't Take Long</p>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="signupForm">

                    <div class="mb-3">
                        <label for="lastName" class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" id="lastName" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" onclick="togglePasswordVisibility('password')">
                                <i class="fas fa-eye"></i>
                                <span class="visually-hidden">Toggle Password Visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label  for="confirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirmPassword')">
                                <i class="fas fa-eye"></i>
                                <span class="visually-hidden">Toggle Password Visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Sign Up Now</button>
                    </div>
                    <p class="text-center text-muted mt-2">
                        By clicking Sign Up Now, you agree to our <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                    </p>
                    <p class="text-center">
                        Already have an account? <a href="login.html">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var toggleButton = document.getElementById("toggle" + inputId.charAt(0).toUpperCase() + inputId.slice(1));

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
                toggleButton.querySelector(".visually-hidden").textContent = "Hide Password";
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
                toggleButton.querySelector(".visually-hidden").textContent = "Show Password";
            }
        }
    </script>
</body>

</html>