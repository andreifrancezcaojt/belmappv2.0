<?php
error_reporting(E_ALL);
session_start();
include_once('../includes/dbcon.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students and Instructors</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
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
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #33c430cf;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 10px 13px;
            vertical-align: middle;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 3px;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination .active a {
            background-color: lightseagreen;
            color: white;
            border: 1px solid lightseagreen;
        }

        .pagination a.glow {
            background-color: green !important;
            color: white !important;
            box-shadow: 0 0 10px green;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- First Table: Students -->
        <div class="table-responsive bg-white shadow">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>Students</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="studentsTable">
                    <thead class="text-center">
                        <tr>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Sex</th>
                            <th>Course</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php

                        $q1 = "SELECT student_id, fullname, sex, course 
                               FROM students ";
                        $rs1 = mysqli_query($conn, $q1);

                        while ($row1 = mysqli_fetch_array($rs1)) {
                            echo '<tr>
                                <td>' . $row1['student_id'] . '</td>
                                <td>' . $row1['fullname'] . '</td>
                                <td>' . $row1['sex'] . '</td>
                                <td>' . $row1['course'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Second Table: Instructors -->
       
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const paginationLinks = document.querySelectorAll(".pagination a");

            paginationLinks.forEach(link => {
                link.addEventListener("click", function() {
                    paginationLinks.forEach(link => link.classList.remove("glow"));
                    this.classList.add("glow");
                });
            });
        });
    </script>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>