<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>

        body {
            margin-top: 0; 
            background-color: #f8f9fa;
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

        .navbar{
            margin-top: 0; 
        }
        .container {
            margin-top: 70px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            width: 400px;
            max-width: 90%;
            font-weight: 400;
            /* margin: -15px 0 15px 0; */
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 15px;
        }

        .container .row .alert{
            font-size: 14px;
        }
        .container .form form .link{
            padding: 5px 0;
        }
        .a{
            color: #007bff;
        }
        .container .login-form form p{
            font-size: 14px;
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
            border-color:#1bc041 ;
        }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
    <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand" href="#">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li> -->
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col mx-5 my-1">
                <form action="new-password.php" method="POST" autocomplete="off">
                    <h2 class="text-center">New Password</h2>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <center>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Create new password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success btn-smaller" type="submit" name="change-password" value="Change">
                    </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>