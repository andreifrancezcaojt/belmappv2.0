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
            padding: 12px 15px;
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
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Sex</th>
                            <th>Course</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q1 = "SELECT student_id, fullname, sex, course 
                               FROM students 
                               LIMIT $start_from1, $num_per_page";
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

                <?php
                $qr1 = "SELECT COUNT(*) AS total_students FROM students";
                $rs_result1 = mysqli_query($conn, $qr1);
                $row1 = mysqli_fetch_assoc($rs_result1);
                $total_records1 = $row1['total_students'];
                $total_pages1 = ceil($total_records1 / $num_per_page);

                echo '<div class="pagination">';
                if ($page1 > 1) {
                    echo '<a href="students_instructors.php?page1=' . ($page1 - 1) . '&page2=' . $page2 . '">Prev</a>';
                }

                for ($i = 1; $i <= $total_pages1; $i++) {
                    echo '<a href="students_instructors.php?page1=' . $i . '&page2=' . $page2 . '" class="' . ($i == $page1 ? 'active' : '') . '">' . $i . '</a>';
                }

                if ($page1 < $total_pages1) {
                    echo '<a href="students_instructors.php?page1=' . ($page1 + 1) . '&page2=' . $page2 . '">Next</a>';
                }
                echo '</div>';
                ?>
            </div>
        </div>

        <!-- Second Table: Instructors -->
        <div class="table-responsive bg-white shadow">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>Instructors</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Instructor ID</th>
                            <th>Full Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q2 = "SELECT instructor_id, fullname 
                               FROM instructors 
                               LIMIT $start_from2, $num_per_page";
                        $rs2 = mysqli_query($conn, $q2);

                        while ($row2 = mysqli_fetch_array($rs2)) {
                            echo '<tr>
                                <td>' . $row2['instructor_id'] . '</td>
                                <td>' . $row2['fullname'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                $qr2 = "SELECT COUNT(*) AS total_instructors FROM instructors";
                $rs_result2 = mysqli_query($conn, $qr2);
                $row2 = mysqli_fetch_assoc($rs_result2);
                $total_records2 = $row2['total_instructors'];
                $total_pages2 = ceil($total_records2 / $num_per_page);

                echo '<div class="pagination">';
                if ($page2 > 1) {
                    echo '<a href="students_instructors.php?page1=' . $page1 . '&page2=' . ($page2 - 1) . '">Prev</a>';
                }

                for ($i = 1; $i <= $total_pages2; $i++) {
                    echo '<a href="students_instructors.php?page1=' . $page1 . '&page2=' . $i . '" class="' . ($i == $page2 ? 'active' : '') . '">' . $i . '</a>';
                }

                if ($page2 < $total_pages2) {
                    echo '<a href="students_instructors.php?page1=' . $page1 . '&page2=' . ($page2 + 1) . '">Next</a>';
                }
                echo '</div>';
                ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const paginationLinks = document.querySelectorAll(".pagination a");

            paginationLinks.forEach(link => {
                link.addEventListener("click", function () {
                    paginationLinks.forEach(link => link.classList.remove("glow"));
                    this.classList.add("glow");
                });
            });
        });
    </script>

    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
