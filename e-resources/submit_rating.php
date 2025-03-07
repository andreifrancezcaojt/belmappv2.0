<?php
require('../includes/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdf_id = $_POST['pdf_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validate and sanitize inputs
    $pdf_id = intval($pdf_id);
    $rating = floatval($rating);
    $comment = htmlspecialchars($comment);

    // Insert or update the rating in the database
    $stmt = $conn->prepare("INSERT INTO ratings (pdf_id, rating, comment) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE rating = VALUES(rating), comment = VALUES(comment)");
    $stmt->bind_param("ids", $pdf_id, $rating, $comment);

    // if ($stmt->execute()) {
    //     echo "<script>alert('Thank you for your rating!'); window.location.href = 'view_pdf.php';</script>";
    // } else {
    //     echo "<script>alert('There was an error. Please try again.'); window.location.href = 'view_pdf.php';</script>";
    // }

    if ($stmt->execute()) {
        header("Location: view_pdf.php?status=success");
    } else {
        header("Location: view_pdf.php?status=error");
    }

    $stmt->close();
    $conn->close();
}
?>
