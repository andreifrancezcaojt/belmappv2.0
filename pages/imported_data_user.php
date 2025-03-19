<?php
error_reporting(E_ALL);
session_start();
include_once('../includes/dbcon.php');

$num_per_page = 10;

// Get current page number for the students table or default to 1 if not set
$page1 = isset($_GET["page1"]) ? max(1, intval($_GET["page1"])) : 1;
$start_from1 = ($page1 - 1) * $num_per_page;

// Get current page number for the instructors table or default to 1 if not set
$page2 = isset($_GET["page2"]) ? max(1, intval($_GET["page2"])) : 1;
$start_from2 = ($page2 - 1) * $num_per_page;
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
            margin: 5px 0;
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

        .pagination {
            float: right;
        }

        .pagination a {
            padding: 8px 12px;
            text-decoration: none;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            color: rgb(33 37 41 / 75%);
            background-color: #e9ecef;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination .active a {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
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
                            <th>Institute</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php

                        $q1 = "SELECT student_id, fullname, sex, course, institute 
                               FROM students 
                            LIMIT $start_from1, $num_per_page";
                        $rs1 = mysqli_query($conn, $q1);

                        while ($row1 = mysqli_fetch_array($rs1)) {
                            echo '<tr>
                                <td>' . $row1['student_id'] . '</td>
                                <td>' . $row1['fullname'] . '</td>
                                <td>' . $row1['sex'] . '</td>
                                <td>' . $row1['course'] . '</td>
                                <td>' . $row1['institute'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                $qr1 = "SELECT COUNT(*) AS total_students FROM students";
                $rs_result1 = mysqli_query($conn, $qr1);
                $row1 = mysqli_fetch_assoc($rs_result1);
                $total_records1 = $row1['total_students'];
                $total_pages1 = ceil($total_records1 / $num_per_page);

                $start_record = ($page1 - 1) * $num_per_page + 1;
                $end_record = min($start_record + $num_per_page - 1, $total_records1);
                echo '<div class="text-end mb-3">Showing ' . $start_record . ' to ' . $end_record . ' of the ' . $total_records1 . ' records</div>';

                echo '<ul class="pagination">';

                // Show "Prev" button, disabled on the first page
                echo '<li class="' . ($page1 == 1 ? 'disabled' : '') . '">
                        <a href="javascript:void(0);" ' . ($page1 > 1 ? 'onclick="loadPage(\'pages/imported_data_user.php?page1=' . ($page1 - 1) . '\',\'maincontent\')"' : 'style="pointer-events: none; color: gray;"') . '>Prev</a>
                      </li>';
                
                // Calculate start and end page to limit to 3 pages
                $start_page = max(1, $page1 - 1);
                $end_page = min($total_pages1, $page1 + 1);
                
                // Adjust range for edge cases
                if ($start_page == 1) {
                    $end_page = min(3, $total_pages1);
                } elseif ($end_page == $total_pages1) {
                    $start_page = max(1, $total_pages1 - 2);
                }
                
                // Display limited page numbers
                for ($i = $start_page; $i <= $end_page; $i++) {
                    echo '<li class="' . ($i == $page1 ? 'active' : '') . '">
                            <a href="javascript:void(0);" onclick="loadPage(\'pages/imported_data_user.php?page1=' . $i . '\',\'maincontent\')">' . $i . '</a>
                          </li>';
                }
                
                // Show "Next" button, disabled on the last page
                echo '<li class="' . ($page1 >= $total_pages1 ? 'disabled' : '') . '">
                        <a href="javascript:void(0);" ' . ($page1 < $total_pages1 ? 'onclick="loadPage(\'pages/imported_data_user.php?page1=' . ($page1 + 1) . '\',\'maincontent\')"' : 'style="pointer-events: none; color: gray;"') . '>Next</a>
                      </li>';
                
                echo '</ul>';
                echo '<div class="text-start fw-bold">Page ' . $page1 . ' of ' . $total_pages1 . '</div>';
                ?>
            </div>
        </div>


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