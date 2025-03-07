<?php
include('../includes/dbcon.php');
if (isset($_FILES['pdf'])) {
    $file_name = $_FILES['pdf']['name'];
    $upload_dir = '../pdf/'; // Update the directory as necessary
    $target_file = $upload_dir . basename($file_name);
    echo json_encode(['exists' => file_exists($target_file)]);
}
?>
