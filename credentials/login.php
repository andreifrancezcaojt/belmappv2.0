<?php
require_once "controllerUserData.php";

if (isset($_SESSION['email'])) {
    header("Location: home.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row['id']; // Set user_id directly from the fetched row
            $_SESSION['password'] = $password; // Not recommended for security reasons

            // Insert login history
            $userId = $_SESSION['user_id'];
            $insertSql = "INSERT INTO login_history (user_id, login_time) VALUES (?, NOW())";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("i", $userId);

            if ($stmt->execute()) {
                echo "Login history inserted successfully!";
            } else {
                echo "Error inserting login history: " . $stmt->error;
            }

            echo "Login successful!";
            header('Location: home.php');
            exit();
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } else {
        $errors['email'] = "Looks like you don't have an account yet. Click the link below to signup.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 15px;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .navbar-brand {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }

        .navbar-brand:hover {
            color: #fff;
        }

        .navbar {
            margin-top: 0;
        }

        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
        }

        .container {
            margin-top: 70px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: 800px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 15px;
        }

        .container .row .alert {
            font-size: 14px;
        }

        .link.login-link {
            padding: 5px 0;
        }

        .btn-primary {
            border-radius: 5px;
        }

        .alert-danger {
            border-radius: 20px;
        }

        .btn-smaller {
            width: auto;
            padding-left: 40px;
            padding-right: 40px;
            border-radius: 10px;
        }

        .btn-smaller:hover {
            transform: scale(1.05);
            box-shadow: 0 0px 10px rgba(0, 0, 0, 0.3);
            background-color: #1bc041;
            border-color: #1bc041;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                margin-top: 60px;
                padding: 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .btn-smaller {
                width: 100%;
            }

            .navbar-brand {
                font-size: 18px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 16px;
            }

            .container {
                margin-top: 40px;
                padding: 15px;
            }
        }

        /* New style for the image */
        .login-image {
            /* max-width: 80%;
            height: auto; 
            margin: 0 auto;  */

            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
        <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="../index.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>

    <br>

    <div class="container mb-1">
        <form action="login.php" method="POST" autocomplete="">
            <div class="row">

                <div class="col-12 col-lg-6 mt-lg-0 text-center">
                    <img src="../assets/icon/lib_front.png" alt="Logo" class="img-fluid login-image">
                </div>

                <div class="col-12 col-lg-6 mt-3">
                    <h2 class="text-center"><i class="fas fa-user mr-2"></i> Login</h2>
                    <p class="text-center">Login with your email and password.</p>
                    <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger text-center">
                            <?php foreach ($errors as $showerror): ?>
                                <?php echo $showerror; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                        <center><a href="forgot-password.php" class="text-success text-center">Forgot password?</a></center>
                    </div>
                    <div class="form-group text-center">
                        <input class="btn btn-success btn-smaller" type="submit" name="login" value="Login">
                    </div>
                    <div class="link login-link text-center">Don't have an account yet? <a href="signup.php" class="text-success text-center">Signup here</a></div>
                </div>


            </div>
        </form>
    </div>

    <footer class="footer mt-auto py-4">
        <div class="mt-5 text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BASC E-Library | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.altKey && event.key === 'a') {
                event.preventDefault(); // Prevent default action
                window.location.href = '../adminlogin.php'; // Redirect to admin login
            }
        });
    </script>

</body>

</html>