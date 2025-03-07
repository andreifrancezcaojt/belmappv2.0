<?php
  require_once("../includes/dbcon.php");
  session_name('user_session');
session_start();

  function isLoggedIn() {
    return isset($_SESSION["user_id"]); // Check if user_id is set in session
  }

  // Validate and sanitize form data
  $thread_id = filter_input(INPUT_POST, "thread_id", FILTER_SANITIZE_NUMBER_INT);
  $reply_content = filter_input(INPUT_POST, "reply_content", FILTER_SANITIZE_STRING);

  if (empty($thread_id) || empty($reply_content)) {
    // Handle missing data error
    echo "Please fill out all fields.";
    exit;
  }

  $user_id = $_SESSION["user_id"]; // Get user ID from session

  $sql = "INSERT INTO replies (thread_id, user_id, content, created_at)
          VALUES (?, ?, ?, NOW())";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iis", $thread_id, $user_id, $reply_content);

  if ($stmt->execute()) {
    // Reply successfully added
    header("Location: view_thread.php?id=$thread_id");
    exit;
  } else {
    // Handle insertion error
    echo "Failed to add reply.";
  }

  $stmt->close();
  $conn->close();
?>