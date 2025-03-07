<?php
require 'vendor/autoload.php'; // Autoload PhpSpreadsheet library

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$servername = "localhost";
$username = "u607950924_basc_elibrary";
$password = "B@scElibrary@2024!";
$dbname = "u607950924_cap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    $file = $_FILES['excelFile']['tmp_name'];
    
    try {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Clear old data
        $clearTableSQL = "TRUNCATE TABLE students";
        if (!$conn->query($clearTableSQL)) {
            echo "Error clearing table: " . $conn->error;
            exit;
        }

        // Assuming the first row is the header
        for ($i = 1; $i < count($rows); $i++) {
            $student_id = $rows[$i][0] ?? null;
            $fullname = $rows[$i][4] ?? '';
            $sex = $rows[$i][8] ?? '';
            $course = $rows[$i][5] ?? '';

            // Skip if student_id is null or empty
            if (empty($student_id)) {
                continue;
            }

            // Check if student_id already exists
            $checkSQL = "SELECT 1 FROM students WHERE student_id = ?";
            $stmt = $conn->prepare($checkSQL);
            $stmt->bind_param("s", $student_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Skip duplicate entries
                $stmt->close();
                continue;
            }
            $stmt->close();

            // Insert the data
            $insertSQL = "INSERT INTO students (student_id, fullname, sex, course) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("ssss", $student_id, $fullname, $sex, $course);

            if (!$stmt->execute()) {
                echo "Error inserting record for student ID $student_id: " . $stmt->error . "<br>";
            }

            $stmt->close();
        }

        echo "Data imported successfully!";
    } catch (Exception $e) {
        echo "Error processing the file: " . $e->getMessage();
    }
} else {
    echo "No file uploaded or incorrect request method.";
}

$conn->close();
?>
