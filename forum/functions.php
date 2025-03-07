<?php
session_name('user_session');
session_start();
include '"../includes/dbcon.php"';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "action" key is set in the $_POST array
    if (isset($_POST['action'])) {
        // Check if the action is for login
        if ($_POST['action'] === 'login') {
            // Check if email and password are set
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                loginProcess($email, $password);
            }
        } 
        // Check if the action is for signup
        elseif ($_POST['action'] === 'signup') {
            // Check if all required fields are set
            if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password']) && isset($_POST['course'])) {
                $email = $_POST['email'];
                $username = $_POST['username'];
                $firstname = $_POST['firstname'];
                $midname = isset($_POST['midname']) ? $_POST['midname'] : '';
                $lastname = $_POST['lastname'];
                $password = $_POST['password'];
                $course = $_POST['course'];
                signupProcess($email, $username, $firstname, $midname, $lastname, $password, $course);
            }
        }
    } else {
        // Handle the case when the "action" key is not set
        echo "Error: Action not specified.";
    }
}

// Function to handle login process
function loginProcess($email, $password) {
    global $conn;

    // Prepare SQL statement to retrieve user data by email
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Insert login history
            $userId = $row['id'];
            $insertSql = "INSERT INTO login_history (user_id) VALUES (?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                // Redirect to home page
                header("Location: ../credentials/home.php");
                exit();
            } else {
                echo "Error inserting login history: " . $conn->error;
            }
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}

// Function to handle signup process
function signupProcess($email, $username, $firstname, $midname, $lastname, $password, $course) {
    global $conn;

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data
    $stmt = $conn->prepare("INSERT INTO users (email, username, firstname, midname, lastname, password, course) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $email, $username, $firstname, $midname, $lastname, $hashedPassword, $course);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Function to display login history
function displayLoginHistory() {
    global $conn;

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT login_time FROM login_history WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>Login Time: " . $row['login_time'] . "</p>";
        }
    } else {
        echo "<p>No login history available</p>";
    }
}

// Function to display threads
function displayThreads() {
    global $conn;

    if (isset($_SESSION["user_id"])) {
        $sql = "SELECT t.*, u.username FROM threads t
                INNER JOIN users u ON t.user_id = u.id
                ORDER BY created_at DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='card thread-card'>";
                echo "<div class='card-header thread-card-header'>";
                echo "<h3 class='card-title thread-card-title'><a href='view_thread.php?id=" . $row["id"] . "'>" . $row["title"] . "</a></h3>";
                echo "<p class='card-text thread-card-info'>Created by: " . $row["username"] . " on " . $row["created_at"] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No threads found.";
        }
    } else {
        header("Location: login.php");
    }
}

// Function to create a new thread
function createThread() {
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION["user_id"])) {
            $title = $_POST["title"];
            $content = $_POST["content"];
            $user_id = $_SESSION["user_id"];

            $sql = "INSERT INTO threads (user_id, title, content)
                    VALUES ($user_id, '$title', '$content')";

            if ($conn->query($sql) === TRUE) {
                header("Location: thread.php");
                exit();
            } else {
                echo "Error creating thread: " . $conn->error;
            }
        } else {
            header("Location: login.php");
            exit();
        }
    }
}
?>
