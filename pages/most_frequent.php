<?php
error_reporting(E_ALL);
session_start();
include_once('../includes/dbcon.php');

$num_per_page = 10;

// Get current page number for the first table or default to 1 if not set
$page1 = isset($_GET["page1"]) ? max(1, intval($_GET["page1"])) : 1;
$start_from1 = ($page1 - 1) * $num_per_page;

// Get current page number for the second table or default to 1 if not set
$page2 = isset($_GET["page2"]) ? max(1, intval($_GET["page2"])) : 1;
$start_from2 = ($page2 - 1) * $num_per_page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log History</title>
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
            padding: 8px 8px;
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

        .pagination a.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        /* New glow effect for clicked button */
        .pagination a.glow {
            background-color: green !important;
            color: white !important;
            box-shadow: 0 0 10px green;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- First Table: Most Frequent User -->
        <div class="table-responsive bg-white shadow">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>Most Frequent User</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Login Frequency</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $q1 = "SELECT a.id, a.username, COUNT(b.user_id) AS login_count
                               FROM users a
                               JOIN login_history b ON a.id = b.user_id
                               GROUP BY a.id, a.username
                               ORDER BY login_count DESC
                               LIMIT $start_from1, $num_per_page";
                        $rs1 = mysqli_query($conn, $q1);

                        while ($row1 = mysqli_fetch_array($rs1)) {
                            echo '<tr>
                                <td>' . $row1['id'] . '</td>
                                <td>' . $row1['username'] . '</td>
                                <td>' . $row1['login_count'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                $qr1 = "SELECT COUNT(DISTINCT a.id) AS total_users 
                        FROM users a
                        JOIN login_history b ON a.id = b.user_id";
                $rs_result1 = mysqli_query($conn, $qr1);
                $row1 = mysqli_fetch_assoc($rs_result1);
                $total_records1 = $row1['total_users'];
                $total_pages1 = ceil($total_records1 / $num_per_page);

                $start_record = ($page1 - 1) * $num_per_page + 1;
                $end_record = min($start_record + $num_per_page - 1, $total_records1);
                echo '<div class="text-end mb-3">Showing ' . $start_record . ' to ' . $end_record . ' of the ' . $total_records1 . ' records</div>';

                echo '<div class="pagination">';
                if ($page1 > 1) {
                    echo '<a href="javascript:void(0);" onclick="loadPage(\'pages/most_frequent.php?page1=' . ($page1 - 1) . '&page2=' . $page2 . '\',\'maincontent\')">Prev</a>';
                }

                for ($i = 1; $i <= $total_pages1; $i++) {
                    echo '<a href="javascript:void(0);" onclick="loadPage(\'pages/most_frequent.php?page1=' . $i . '&page2=' . $page2 . '\',\'maincontent\')" class="' . ($i == $page1 ? 'active' : '') . '">' . $i . '</a>';
                }

                if ($page1 < $total_pages1) {
                    echo '<a href="javascript:void(0);" onclick="loadPage(\'pages/most_frequent.php?page1=' . ($page1 + 1) . '&page2=' . $page2 . '\',\'maincontent\')">Next</a>';
                }
                
                // Show "Next" button, disabled on the last page
                echo '<a href="javascript:void(0);" ' . ($page1 < $total_pages1 ? 'onclick="loadPage(\'pages/most_frequent.php?page1=' . ($page1 + 1) . '&page2=' . $page2 . '\',\'maincontent\')"' : 'style="pointer-events: none; color: gray;"') . '>Next</a>';
                
                echo '</div>';

                echo '<div class="text-start fw-bold">Page ' . $page1 . ' of ' . $total_pages1 . '</div>';
                ?>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to add the glow effect to clicked pagination links
        document.addEventListener("DOMContentLoaded", function() {
            const paginationLinks = document.querySelectorAll(".pagination a");

            paginationLinks.forEach(link => {
                link.addEventListener("click", function() {
                    // Remove the glow class from all links
                    paginationLinks.forEach(link => link.classList.remove("glow"));
                    // Add the glow class to the clicked link
                    this.classList.add("glow");
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>