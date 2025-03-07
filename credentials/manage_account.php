<?php
require_once "controllerUserData.php";

// Database connection
// $servername = "localhost:3307"; // adjust as necessary
// $username = "root"; // adjust as necessary
// $password = ""; // adjust as necessary
// $dbname = "cap"; // replace with your database name

$servername = "localhost";
$username = "u607950924_basc_elibrary";
$password = "B@scElibrary@2024!";
$dbname = "u607950924_cap";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve basic account details from the users table
$query = "SELECT id, username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing statement for users table: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Retrieve full name from either students or instructors table
$fullname = null;

// Check students table for fullname
$query = "SELECT fullname FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing statement for students table: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $fullname = $result->fetch_assoc()['fullname'];
} else {
    // If not found, check instructors table
    $query = "SELECT fullname FROM instructors WHERE instructor_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error preparing statement for instructors table: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fullname = $result->fetch_assoc()['fullname'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            /* background-color: #39ff001a; */
            /* padding-top: 50px; */
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

        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
            /* Toggler border color */
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
    <br><br><br>

    <div class="container mt-1 mb-5">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Back button -->
            <a href="home.php" class="btn text-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <h2 class="text-center">Manage Account</h2>

        <div class="jumbotron mt-4 p-4 mb-5">

            <h5 class="text-center">Your Account Information</h5>
            <table class="table mt-3">
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td><?php echo htmlspecialchars($fullname ?: "Not available"); ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            </table>
            <div class="text-center mt-4">
                <a href="change_password.php" class="btn btn-success">Change your password</a>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto mt-5">
        <div class="container text-center mt-5">
            <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>