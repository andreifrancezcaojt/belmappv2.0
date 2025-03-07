<?php
include '../includes/dbcon.php'; // Ensure correct database connection

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ['status' => 'error', 'message' => '']; // Default response

// Ensure all required fields are present
if (!isset($_FILES['pdf'], $_POST['pdf_name'], $_POST['category'])) {
    $response['message'] = 'Required fields are missing.';
    echo json_encode($response);
    exit();
}
$pdf_callnumber = mysqli_real_escape_string($conn, $_POST['pdf_callnumber']);
$pdf_name = mysqli_real_escape_string($conn, $_POST['pdf_name']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$file = $_FILES['pdf'];

// Validate file type
if ($file['type'] !== 'application/pdf') {
    $response['message'] = 'Invalid file type. Only PDFs are allowed.';
    echo json_encode($response);
    exit();
}

// Check for duplicate names
$checkDuplicateName = mysqli_query($conn, "SELECT * FROM pdf_file WHERE pdf_name = '$pdf_name'");
if (mysqli_num_rows($checkDuplicateName) > 0) {
    $response['message'] = 'A PDF with the same name already exists.';
    echo json_encode($response);
    exit();
}

// Prepare upload directory
$upload_dir = '../pdf/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
}

$target_file = $upload_dir . basename($file['name']);

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $target_file)) {
    // Insert into the database
    $query = "INSERT INTO pdf_file (pdf_callnumber, pdf_name, pdf, category) VALUES ('$pdf_callnumber', '$pdf_name', '{$file['name']}', '$category')";
    if (mysqli_query($conn, $query)) {
        $response['status'] = 'success';
        $response['message'] = 'PDF uploaded and saved successfully.';
    } else {
        $response['message'] = 'Database Error: ' . mysqli_error($conn); // Detailed error
    }
} else {
    $response['message'] = 'Failed to upload the file.';
}

echo json_encode($response);
?>
