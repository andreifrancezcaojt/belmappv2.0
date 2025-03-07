<?php
require 'vendor/autoload.php'; // Load PhpSpreadsheet
// include('../../../includes/dbcon.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection
// $host = 'localhost:3307';   // Change this to your host
// $username = 'root';     // Change this to your DB username
// $password = '';         // Change this to your DB password
// $database = 'cap'; // Change this to your DB name

$servername = "localhost";
$username = "u607950924_basc_elibrary";
$password = "B@scElibrary@2024!";
$dbname = "u607950924_cap";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get data from open_access_database table
$sql = "SELECT id, oadb_name, oadb_url FROM open_access_db";
$result = $conn->query($sql);

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headers
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Open Access Database');
// $sheet->setCellValue('C1', 'Image');
$sheet->setCellValue('D1', 'URL');

// Fill data from the database into the spreadsheet
if ($result->num_rows > 0) {
    $row = 2; // Start from row 2 since row 1 is for headers
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['oadb_name']);
        // $sheet->setCellValue('C' . $row, $data['image']);
        $sheet->setCellValue('D' . $row, $data['oadb_url']);
        $row++;
    }
}

// Save the spreadsheet to a file and download
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="BELMAppv2.0_open_access_database.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output'); // Output to browser for download
exit;

?>
