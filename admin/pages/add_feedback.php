<?php
session_name('admin_session');
session_start();
include_once('../../includes/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_name = mysqli_real_escape_string($conn, $_POST['feedback_name']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $feedback_url = mysqli_real_escape_string($conn, $_POST['feedback_url']);

    $query = "INSERT INTO feedback_qr (feedback_name, image, feedback_url) VALUES ('$feedback_name', '$image', '$feedback_url')";
    
    if (mysqli_query($conn, $query)) {
        echo "Feedback added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
