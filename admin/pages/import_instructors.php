<?php
require 'vendor/autoload.php'; // This will autoload the PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "cap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];
    
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Clear old data
    $clearTableSQL = "TRUNCATE TABLE instructors";
    if (!$conn->query($clearTableSQL)) {
        echo "Error clearing table: " . $conn->error;
    }

    // Assuming the first row is the header
    for ($i = 1; $i < count($rows); $i++) {
        $instructor_id = $rows[$i][0];
        $fullname = $rows[$i][1];

        $sql = "INSERT INTO instructors (instructor_id, fullname) VALUES ('$instructor_id', '$fullname')";
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo "Data imported successfully!";
} else {
    echo "No file uploaded or incorrect request method.";
}

$conn->close();
?>
