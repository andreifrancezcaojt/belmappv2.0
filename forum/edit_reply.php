<?php
// Include necessary files and start session
require_once("../includes/dbcon.php");
session_name('user_session');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user_id']; // Current logged-in user ID

// Initialize variables
$reply_content = "";
$error_message = "";

// Handle form submission for updating the reply
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["reply_id"]) && !empty($_POST["reply_content"]) && !empty($_POST["thread_id"])) {
        $reply_id = intval($_POST["reply_id"]); // Sanitize reply ID
        $thread_id = intval($_POST["thread_id"]); // Sanitize thread ID
        $reply_content = trim($_POST["reply_content"]); // Trim unnecessary spaces

        // Update the reply in the database
        $sql = "UPDATE replies SET content = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $reply_content, $reply_id, $user_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            // Redirect back to the thread after successful update
            header("Location: view_thread.php?id=$thread_id");
            exit();
        } else {
            $error_message = "Failed to update the reply. Either it doesn't exist or you don't have permission.";
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}

// Fetch the reply data if reply_id and thread_id are present
if (isset($_GET['reply_id']) && isset($_GET['thread_id'])) {
    $reply_id = intval($_GET["reply_id"]);
    $thread_id = intval($_GET["thread_id"]);

    // Fetch the reply from the database
    $sql = "SELECT content FROM replies WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $reply_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reply = $result->fetch_assoc();
        $reply_content = $reply['content'];
    } else {
        die("Reply not found or access denied.");
    }
    $stmt->close();
} else {
    die("Invalid request. Reply ID and thread ID are required.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reply</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 80px;
            max-width: 600px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top shadow">
        <div class="brand-container">
            <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo">
        </div>
        <a class="navbar-brand" href="../credentials/home.php">BASC E-Library</a>
    </nav>

    <div class="container">
        <h2>Edit Reply</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="replyContent">Reply Content</label>
                <textarea class="form-control" name="reply_content" id="replyContent" rows="5"><?php echo htmlspecialchars($reply_content); ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <input type="hidden" name="reply_id" value="<?php echo $reply_id; ?>">
            <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>