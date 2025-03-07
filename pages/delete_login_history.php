<?php
include_once('../includes/dbcon.php');

// Attempt to delete login history
$query = "DELETE FROM login_history";
$result = mysqli_query($conn, $query);

// If the deletion was successful, return a "204 No Content" response
if ($result) {
    http_response_code(204); // Indicate success with no content
    exit();
} else {
    // Return the error as JSON for better debugging
    http_response_code(500); // Internal server error
    echo json_encode(['error' => mysqli_error($conn)]);
    exit();
}
?>
