<?php
require_once "controllerUserData.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up Form</title>
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
            /* Toggler border color */
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

        .signup-image {
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
        <form action="signup.php" method="POST" autocomplete="">
            <div class="row">

                <div class="col-12 col-lg-6 mt-lg-0 text-center">
                    <img src="../assets/icon/lib_front.png" alt="Vector Image" class="img-fluid signup-image">
                </div>

                <div class="col-12 col-lg-6 mt-1">
                    <h2 class="text-center"><i class="fas fa-user mr-2"></i>Sign up</h2>
                    <p class="text-center">Provide the needed information to sign up.</p>
                    <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger text-center">
                            <?php foreach ($errors as $showerror): ?>
                                <?php echo $showerror; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="id" placeholder="ID Number" required>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="username" placeholder="Username" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
                    </div>

                    <div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="cpassword" placeholder="Confirm password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <input type="checkbox" id="termsCheckbox" required> I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a>.
                    </div>
                    <div class="form-group text-center">
                        <input class="btn btn-success btn-smaller" type="submit" name="signup" value="Sign up">
                    </div>
                    <div class="link login-link text-center">Already have an account? <a href="login.php" class="text-success">Login here</a></div>
                </div>

            </div>
        </form>
    </div>

    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>1. Acceptance of Terms:</b> By using the BASC E-Library platform, you agree to comply with these Terms and Conditions. If you do not agree, you should discontinue your use of the platform immediately.</p>
                    <p><b>2. User Accounts and Responsibilities:</b> You are required to create an account to access the e-library. When registering, you agree to provide accurate, current, and complete information. You are solely responsible for maintaining the confidentiality of your login credentials and for any activities that occur under your account.</p>
                    <p><b>3. Use of Platform:</b> The BASC E-Library platform is intended for educational and research purposes only. You agree to use the resources, including e-books, research papers, and other digital content, for personal or academic use and not for commercial gain.</p>
                    <p><b>4. Prohibited Activities:</b> You agree not to:
                    <ul>
                        <li>Engage in any unlawful activities through the platform.</li>
                        <li>Share or distribute content obtained from the e-library with unauthorized persons or platforms.</li>
                        <li>Attempt to bypass security measures, or gain unauthorized access to restricted sections of the platform.</li>
                        <li>Upload or distribute viruses or any harmful software.</li>
                    </ul>
                    </p>
                    <p><b>5. Intellectual Property:</b> All materials, including e-books, articles, and multimedia content available on BASC E-Library, are protected by copyright laws. You are granted limited access for personal or academic use and are prohibited from reproducing, distributing, or modifying any content without permission from the rights holder.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-2">
        <div class="mt-5 text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BASC E-Library | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <!-- <footer class="footer">
        <div class="text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BASC E-Library | Bulacan Agricultural State College.</span>
        </div>
    </footer> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to validate checkbox -->
    <script>
        function validateForm() {
            if (!document.getElementById('termsCheckbox').checked) {
                alert('You must agree to the terms and conditions before signing up.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>