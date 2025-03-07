<?php
require_once "controllerUserData.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login_style.css">
    <link rel="stylesheet" href="css/style.css">
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
            padding: 10px;
            /* Increased padding for better aesthetics */
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: 400px;
            max-width: 70%;
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

        .container .login-form form p {
            font-size: 14px;
        }

        .btn-primary {
            border-radius: 5px;
        }

        .alert-danger {
            border-radius: 20px;
        }

        .btn-smaller {
            width: 100%;
            /* Make the button full width */
            padding: 10px;
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
            .navbar-brand {
                font-size: 18px;
            }

            .container {
                margin-top: 60px;
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .btn {
                font-size: 14px;
                /* Smaller button text */
            }

            .form-control {
                font-size: 14px;
                /* Smaller input text */
            }
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

    <div class="container">
        <div class="row justify-content-center"> <!-- Centering the form on larger screens -->
            <div class="col-12 col-md-6 "> <!-- Responsive column sizes -->
                <form action="forgot-password.php" method="POST" autocomplete="">
                    <h2 class="text-center">Forgot Password</h2>
                    <p class="text-center">Enter your email address</p>
                    <?php
                    if (count($errors) > 0) {
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach ($errors as $error) {
                                echo $error;
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success btn-smaller mb-2" type="submit" name="check-email" value="Continue">

                        <a class="btn btn-secondary btn-smaller" href="../index.php">Exit</a>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-4">
        <div class="mt-5 text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BASC E-Library | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>