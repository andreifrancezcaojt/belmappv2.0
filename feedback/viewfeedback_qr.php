<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback Form</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> <!-- Include QRCode.js -->

    <style>
        body {
            /* background-color: #f2f4f7; */
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
        }

        .navbar-nav .nav-link {
            margin-right: 10px;
        }

        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
        }

        .card {
            margin-bottom: 20px;
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        /* .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        } */

        .card-image img {
            max-width: 100%;
            height: auto;
            /* Maintain aspect ratio */
            object-fit: contain;
            /* Keep the image contained in the card */
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        .jumbotron {
            background-color: #fff;
            border-radius: 20px;
            color: #000;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .text-main {
            font-size: 30px;
        }

        footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 16px;
            }

            .logo {
                max-width: 40px;
            }

            .text-main {
                font-size: 24px;
            }

            .jumbotron {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 14px;
            }

            .logo {
                max-width: 30px;
            }

            .text-main {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
        <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="../credentials/home.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>

    <div class="container mt-5">

        <div class="mt-3 mb-1  d-flex w-100  justify-content-start align-items-center">

            <a href="../credentials/home.php" class="btn text-secondary ">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>

        </div>

        <div class="jumbotron text-center">
            <h1 class="text-main">Give us a feedback!</h1>
            <hr class="my-1">
            <p>Share your thoughts with us so we can improve our services. Click the link or scan the QR code to open the feedback form.</p>
        </div>
        
    </div>

    <?php
    require('../includes/dbcon.php');
    $query = mysqli_query($conn, "SELECT feedback_url FROM feedback_qr");

    if (mysqli_num_rows($query) > 0) {
        echo '<div class="container">';
        while ($row = mysqli_fetch_array($query)) {
    ?>
            <center>
                <div class="">
                    <div class="card">
                        <div id="qrcode" style="margin-top: 50px;"></div>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="<?php echo $row['feedback_url']; ?>" target="_blank">
                                    <?php echo $row['feedback_url']; ?>
                                </a>
                                <input type="hidden" id="url" value="<?php echo $row['feedback_url'] ?>">
                            </h5>
                        </div>
                    </div>
                </div>
            </center>

    <?php
        }
        echo '</div>';
    } else {
        echo "No URL Found!";
    }
    ?>

    <!-- 

  <footer class="footer mt-auto text-center py-2">
    <div class="container">
      <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
    </div>
  </footer> -->


    <script>
        var feedbackUrl = document.getElementById('url').value; // Get the feedback URL from PHP

        // Generate QR Code
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: feedbackUrl,
            width: 300, // QR code width
            height: 300, // QR code height
        });
    </script>

    <!-- Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>