<?php
// Assuming $conn is the database connection
include('../includes/dbcon.php');
if (isset($_POST['pdf_name'])) {
    $pdf_name = $_POST['pdf_name'];
    $query = "SELECT * FROM pdf_file WHERE pdf_name = '$pdf_name'";
    $result = mysqli_query($conn, $query);
    echo json_encode(['exists' => mysqli_num_rows($result) > 0]);
}
?>
