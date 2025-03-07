<?php
session_start();
include_once('../includes/dbcon.php');

$num_per_page = 10;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $num_per_page;

// Updated SQL query to join users with both students and instructors tables
$query = "
    SELECT 
        users.id AS student_id, 
        COALESCE(students.fullname, instructors.fullname) AS fullname, 
        users.username, 
        users.email, 
        COALESCE(students.course, 'Instructor') AS course 
    FROM users 
    LEFT JOIN students ON users.id = students.student_id 
    LEFT JOIN instructors ON users.id = instructors.instructor_id
    LIMIT $start_from, $num_per_page";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
 <style>
    body {
        padding-top: 0px;
        color: #566787;
        background: #f5f5f5;
    }
    .table-responsive {
        margin: 30px 0;
    }
    .table-wrapper {
        min-width: 1000px;
        background: #fff;
        padding: 20px 25px;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 15px;
        background: lightseagreen;
        color: #fff;
        padding: 16px 30px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }
    .table-title .btn-group {
        float: right;
    }
    .table-title .btn {
        color: #fff;
        float: right;
        font-size: 13px;
        border: none;
        min-width: 50px;
        border-radius: 2px;
        border: none;
        outline: none !important;
        margin-left: 10px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
        padding: 12px 15px;
        vertical-align: middle;
    }
    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }
    table.table-striped.table-hover tbody tr:hover {
        background: #f5f5f5;
    }
</style>

<div class="container">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-xs-6">
                        <h2><b>Users</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Course / Instructor</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($rw = mysqli_fetch_array($result)) {
                    echo '<tr>
                            <td>'.$rw['student_id'].'</td>
                            <td>'.$rw['fullname'].'</td>
                            <td>'.$rw['username'].'</td>
                            <td>'.$rw['email'].'</td>
                            <td>'.$rw['course'].'</td>
                          </tr>';
                }
                ?>
                </tbody>
            </table>   

            <?php
            // Pagination
            $qr = "SELECT * FROM users";
            $rs_result = mysqli_query($conn, $qr);
            $total_records = mysqli_num_rows($rs_result);
            $total_pages = ceil($total_records / $num_per_page);

            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a class="btn btn-primary btn-sm" style="margin-right: 5px;" href="javascript:void(0);" onclick="loadPage(\'pages/users.php?page='.$i.'\',\'maincontent\')">'.$i.'</a>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
