<?php

if (isset($_SESSION['email'])) {
    header("Location: home.php");
    exit();
}

if(isset($_GET['login'])){
    include('login.php');
    exit(0);
}

if(isset($_GET['signup'])){
    include('signup-user.php');
    exit(0);
}

if(isset($_GET['adminlogin'])){
    include('adminlogin.php');
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BELLMAPPv2.0</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            /* background-color: #f2f4f7; */
            background-color: #f8f9fa;
            padding-top: 15px;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .navbar {
            color: #fff;
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

        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
        }

        .jumbotron {
            margin-top: 80px;
            background-color: #ffffff;
            color: #000000;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            padding: 40px;
        }

        .custom-btn1, .custom-btn2 {
            border-radius: 5px;
            width: 120px;
            color: #fff;
        }

        .custom-btn1 {
            border-color: #1f8135;
            background-color: #28a745;
        }

        .custom-btn2 {
            border-color: #c79500;
            background-color: #f5b800;
        }

        .custom-btn1:hover {
            transform: scale(1.05);
            box-shadow: 0 0px 10px rgba(0, 0, 0, 0.3);
            background-color: #1bc041;
            border-color: #1bc041;
            color: #fff;
        }

        .custom-btn2:hover {
            transform: scale(1.05);
            box-shadow: 0 0px 10px rgba(0, 0, 0, 0.3);
            background-color: #ffca2d;
            border-color: #ffca2d;
            color: #fff;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 768px) {
            .jumbotron {
                margin-top: 60px;
                padding: 30px;
            }

            .navbar-brand {
                font-size: 16px;
            }

            .jumbotron .row {
                flex-direction: column;
                align-items: center;
            }

            .jumbotron .col-12 {
                text-align: center;
            }

            .custom-btn1, .custom-btn2 {
                width: 100px;
            }

            .navbar-toggler {
                margin-right: 15px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 14px;
            }

            .jumbotron {
                margin-top: 40px;
                padding: 20px;
            }

            .jumbotron .col-lg-6 img {
                width: 80%;
                margin: 10px 0;
            }

            .custom-btn1, .custom-btn2 {
                width: 90px;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 400px) {
            .jumbotron h1 {
                font-size: 28px;
            }
            
            .jumbotron p.lead {
                font-size: 14px;
            }

            .custom-btn1, .custom-btn2 {
                width: 80px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
        <img class="logo" src="assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="#">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="jumbotron">
            <div class="row">
                <!-- Text Section -->
                <div class="col-12 col-lg-6 text-center text-lg-left">
                    <h1 class="display-4 fw-bold">Welcome to BELMAppv2.0</h1>
                    <p class="lead">Explore our vast collection of digital resources.</p>
                    <hr class="my-4">
                    <p>Create an account and login to start browsing for your topic of interest.</p>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="credentials/login.php" class="btn mr-3 custom-btn1">Login</a>
                        <a href="credentials/signup.php" class="btn custom-btn2">Signup</a>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center mt-4 mt-lg-0">
                    <center>
                        <img src="assets/icon/cloud_books.png" alt="Image Description" class="img-fluid" style="max-width: 90%; height: auto;">
                    </center>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <!-- Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
