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
            float: right;
            padding: 8px 12px;
            text-decoration: none;
            margin-bottom: 2 px;
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
        <div class="table-responsive bg-white shadow">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>User Login History</b></h2>
                        </div>
                        <!-- <div class="col-xs-6 text-end">
                            <button type="button" onclick="deleteLoginHistory()" class="btn btn-danger btn-sm">Delete Login History</button>
                        </div> -->
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Login Time</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $q2 = "SELECT b.user_id, a.username, b.login_time
                               FROM users a
                               JOIN login_history b ON a.id = b.user_id
                               ORDER BY b.login_time DESC
                               LIMIT $start_from2, $num_per_page";
                        $rs2 = mysqli_query($conn, $q2);

                        while ($row2 = mysqli_fetch_array($rs2)) {
                            echo '<tr>
                                <td>' . $row2['user_id'] . '</td>
                                <td>' . $row2['username'] . '</td>
                                <td>' . $row2['login_time'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                $qr2 = "SELECT COUNT(*) AS total_logins 
                        FROM login_history b
                        JOIN users a ON a.id = b.user_id";
                $rs_result2 = mysqli_query($conn, $qr2);
                $row2 = mysqli_fetch_assoc($rs_result2);
                $total_records2 = $row2['total_logins'];
                $total_pages2 = ceil($total_records2 / $num_per_page);

                $start_record2 = ($page2 - 1) * $num_per_page + 1;
                $end_record2 = min($start_record2 + $num_per_page - 1, $total_records2);
                echo '<div class="text-end mb-3">Showing ' . $start_record2 . ' to ' . $end_record2 . ' of the ' . $total_records2 . ' records</div>';
                
                echo '<ul class="pagination">';

                // Show "Prev" button, disabled on the first page
                echo '<li class="' . ($page2 == 1 ? 'disabled' : '') . '">
                        <a href="javascript:void(0);" ' . ($page2 > 1 ? 'onclick="loadPage(\'pages/loghistory.php?page1=' . $page1 . '&page2=' . ($page2 - 1) . '\',\'maincontent\')"' : '') . '>Prev</a>
                    </li>';

                // Calculate start and end page for limiting to 3 pages
                $start_page = max(1, $page2 - 1);
                $end_page = min($total_pages2, $page2 + 1);

                // Adjust if near start or end of pages
                if ($start_page == 1) {
                    $end_page = min(3, $total_pages2);
                } elseif ($end_page == $total_pages2) {
                    $start_page = max(1, $total_pages2 - 2);
                }

                // Display page numbers
                for ($i = $start_page; $i <= $end_page; $i++) {
                    echo '<li class="' . ($i == $page2 ? 'active' : '') . '">
                            <a href="javascript:void(0);" onclick="loadPage(\'pages/loghistory.php?page1=' . $page1 . '&page2=' . $i . '\',\'maincontent\')">' . $i . '</a>
                        </li>';
                }

                // Show "Next" button, disabled on the last page
                echo '<li class="' . ($page2 >= $total_pages2 ? 'disabled' : '') . '">
                        <a href="javascript:void(0);" ' . ($page2 < $total_pages2 ? 'onclick="loadPage(\'pages/loghistory.php?page1=' . $page1 . '&page2=' . ($page2 + 1) . '\',\'maincontent\')"' : '') . '>Next</a>
                    </li>';
                echo '</ul>';
                echo '<div class="text-start fw-bold">Page ' . $page2 . ' of ' . $total_pages2 . '</div>';
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


        function loadPage(url, target) {
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(target).innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener("DOMContentLoaded", function() {
            const paginationLinks = document.querySelectorAll(".pagination a");

            paginationLinks.forEach(link => {
                link.addEventListener("click", function() {
                    // Remove "active" class from all pagination items
                    document.querySelectorAll(".pagination li").forEach(li => li.classList.remove("active"));

                    // Add "active" class to the clicked pagination link's parent <li>
                    this.parentElement.classList.add("active");
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>