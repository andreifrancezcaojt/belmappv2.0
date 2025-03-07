<?php
session_name('admin_session');
session_start();
include('includes/dbcon.php');

if (isset($_POST['adminloginbtn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $select_student = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email = '$email' AND password = '$password'");
    $count_student = mysqli_num_rows($select_student);
    if ($count_student == 1) {
        while ($result = mysqli_fetch_array($select_student)) {
            $_SESSION['email'] = $result['email'];
        }
        header('location: admindashboard.php');
        exit();
    } else {
        echo '<script>
        setTimeout(function () {
            alert("Invalid Email or Password");
            window.location.href = "adminlogin.php";
        }, 200);
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
        <img class="logo" src="assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="index.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>

    <br>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 text-center mb-1">
                <img src="assets/icon/lib_front.png" alt="Library Logo" class="img-fluid login-image"> <!-- Added class here -->
            </div>
            <div class="col-md-6 mt-2">
                <h3 class="text-center mt-3"><i class="fas fa-user-shield mr-2"></i>Administrator Login</h3>
                <hr class="my-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope mr-2"></i>Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock mr-2"></i>Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <center>
                        <button type="submit" class="btn btn-success btn-block btn-smaller" name="adminloginbtn"><i class="fas fa-sign-in-alt mr-2"></i>Login</button>
                    </center>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-4">
        <div class="mt-5 text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BASC E-Library | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let keys = {};
        const adminUrl = 'adminlogin.php';
        const userUrl = 'credentials/login.php';

        window.addEventListener('keydown', function(event) {
            if (event.key === 'Control' || event.key === 'Alt') {
                event.preventDefault();
            }

            keys[event.key] = true;

            if (keys['Control'] && keys['Alt'] && keys['a']) {
                window.location.href = adminUrl;
            } else if (keys['Control'] && keys['Alt'] && keys['u']) {
                window.location.href = userUrl;
            }
        });

        window.addEventListener('keyup', function(event) {
            keys[event.key] = false;
        });
    </script>

</body>

</html>