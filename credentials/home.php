<?php
require_once "controllerUserData.php";

// Redirect to login if session email is not set or empty
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}


require_once "../includes/dbcon.php"; // Ensure database connection is loaded

// Initialize variables
$opac_link = "#";
$email = $_SESSION['email'];

// Fetch OPAC link
$query = "SELECT opac_link FROM opac LIMIT 1";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $opac_link = htmlspecialchars($row['opac_link']);
    }
}

// Fetch user details
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result && $user_result->num_rows > 0) {
        $fetch_info = $user_result->fetch_assoc();
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        $student_id = $fetch_info['id'];

        // Handle verification and reset code statuses
        if ($status !== "verified") {
            header('Location: credentials/user-otp.php');
            exit();
        }

        if ($code != 0) {
            header('Location: credentials/reset-code.php');
            exit();
        }

        // Determine user type
        $user_type_query = "
            SELECT fullname 
            FROM students 
            WHERE student_id = ? 
            UNION 
            SELECT fullname 
            FROM instructors 
            WHERE instructor_id = ?
        ";
        $stmt = $conn->prepare($user_type_query);
        if ($stmt) {
            $stmt->bind_param("ss", $student_id, $student_id);
            $stmt->execute();
            $user_type_result = $stmt->get_result();

            if ($user_type_result && $user_type_result->num_rows > 0) {
                $user_info = $user_type_result->fetch_assoc();
                $fullname = htmlspecialchars($user_info['fullname']);
            } else {
                $fullname = "Unknown";
            }
        } else {
            $fullname = "Unknown";
        }
    } else {
        // Redirect if user not found
        session_destroy();
        header('Location: index.php');
        exit();
    }
} else {
    // Redirect if query fails
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $fullname; ?> | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .home-button {
            display: inline-block;
            margin: 10px;
            padding: 15px 20px;
            border: 3px solid #b90b1c;
            border-radius: 5px;
            background-color: #b90b1c;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
            width: calc(100% - 20px);
            max-width: 250px;
            box-sizing: border-box;
        }

        .navbar-brand {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }


        .jumbotron {
            background-color: #fff;
            border-radius: 5px;
            color: #000;
            padding: 2rem;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .text-main {
            font-weight: 700;
            font-size: 2.5rem;
        }

        .homebutton-container .home-button {
            text-decoration: none;
            color: #fff;
        }

        .homebutton-container .home-button:hover {
            text-decoration: none;
            color: #fff;
            background-color: #860a16;
            border-radius: 5px;/
        }


        .homebutton-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px 0;
        }

        .logo {
            max-width: 50px;
            height: auto;
        }

        .img-small {
            max-width: 300px;
            height: auto;
        }

        .navbar-nav .nav-item .dropdown-item:hover {
            background-color: transparent !important;
            color: #ccffd8 !important;
            text-decoration: none !important;
        }

        @media (max-width: 576px) {
            .text-main {
                font-size: 1.75rem;
            }

            .home-button {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top shadow">
        <div class="brand-container">
            <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        </div>
        <a class="navbar-brand" href="home.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="dropdown-item text-light" href="../about_developer/aboutdeveloper.php"><i class="fas fa-user me-2 mr-2"></i>About Developers</a></li>
                <li class="nav-item"><a class="dropdown-item text-light" href="../feedback/viewfeedback_qr.php"><i class="fas fa-comment-dots me-2 mr-2"></i>Feedback</a></li>
                <li class="nav-item"><a class="dropdown-item text-light" href="manage_account.php"><i class="fas fa-cogs me-2 mr-2"></i>Manage Account</a></li>
                <li class="nav-item"><a class="dropdown-item text-light" href="logout-user.php"><i class="fas fa-sign-out-alt me-2 mr-2"></i>Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="jumbotron">
            <!-- Close Button -->
            <button id="closeButton" class="btn btn-danger" style="position: absolute; top: 10px; right: 10px;">Close</button>

            <div class="row">
                <div class="col-md-7 col-12">
                    <h1 class="fw-bolder text-dark text-main">BELMAppv2.0:</h1>
                    <h2 class="fw-bolder text-secondary">BASC E-Library with Interactive Forum</h2>
                    <hr class="my-3">
                    <p class="lead text-success">Welcome, <?php echo htmlspecialchars($fullname); ?>!</p>
                    <p>Delve into a diverse collection of e-resources like e-books, scholarly journals, e-articles, and educational resources. Expand your horizons and empower your learning experience through our open access databases! Search, read, and learn!</p>
                </div>
                <div class="col-md-5 col-12 text-center">
                    <img src="../assets/icon/home_image.png" alt="Vector Image" class="img-fluid img-small">
                </div>
            </div>
        </div>
    </div>

    <div class="homebutton-container">
        <a href="../openaccessDB/viewdatabase.php" class="home-button">
            <img src="../assets/icon/oadw.png" alt="Open Access Databases" style="width: 40px; height: 40px;">
            Open Access Databases
        </a>

        <a href="../e-resources/view_pdf.php" class="home-button">
            <img src="../assets/icon/bookw.png" alt="E-Resources" style="width: 40px; height: 40px;">
            E-Resources
        </a>

        <a href="../forum/split_screen.php" class="home-button">
            <img src="../assets/icon/forumw.png" alt="Forum" style="width: 40px; height: 40px;">
            Forum
        </a>

        <a href="<?php echo $opac_link; ?>" target="_blank" class="home-button" id="opacButton">
            <img src="../assets/icon/opacw.png" alt="Online Public Access Catalogue" style="width: 40px; height: 40px;">
            OPAC
        </a>
    </div>

    <footer class="footer mt-auto py-1">
        <div class="container text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script>
        // Add event listener to close the tab or window
        document.getElementById('closeButton').addEventListener('click', function() {
            window.close();
        });

        // Add event listener to trigger the close button when OPAC link is clicked
        document.getElementById('opacButton').addEventListener('click', function() {
            const closeButton = document.getElementById('closeButton');
            closeButton.click(); // Simulate the close button click
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>