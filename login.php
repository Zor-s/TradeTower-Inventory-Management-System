<?php
include './connector.php';

$connector = new connector();
$connector2 = new connector();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    // Sanitize POST array
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $connector->conn->prepare('SELECT password FROM customers WHERE username = ?');
    $stmt->bind_param('s', $username);

    // Execute statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($hashed_password);

    // Fetch the result
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashed_password)) {


        $sql = "SELECT customer_id FROM customers WHERE username = ?";
        $stmt = $connector2->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $_SESSION["customer_id"] = $row["customer_id"];
                    echo "<script>window.location.href='./customer.php';</script>";

                }
            } else {
                echo "0 results";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $connector2->conn->error;
        }

        $connector2->conn->close();
    } else {
    
        echo "<script>alert('Invalid username or password');</script>";
        echo "<script>window.location.href='./login.php';</script>";
    }

    // Close statement and connection
    $stmt->close();
}
$connector->conn->close();
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/all.min.css">
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
            font-size: 30px;
        }
    </style>
</head>

<body class="bg-light">
    <header>
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
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-lg-4 bg-white rounded p-4">
                    <h2 class="text-center">Log In</h2>
                    <p class="text-center text-muted lead">Welcome!</p>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input name="username" type="text" class="form-control" id="username" placeholder="username" required>
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
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary mb-3">Log In</button>
                        </div>
                    </form>

                    <p class="text-center">
                        Not a Member? <a href="signup.html">Signup Here</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

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