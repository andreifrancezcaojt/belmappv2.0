<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../../includes/dbcon.php');
?>
<div class="table-responsive">
    <div class="table-wrapper">
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th>#</th> <!-- Sequential Number Column -->
                    <th>Admin Email</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $num_per_page = 10;

                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }

                $start_from = ($page - 1) * $num_per_page;
                $previous_page = $page - 1;
                $next_page = $page + 1;

                $query = "SELECT * FROM tbl_admin";
                
                if (isset($_GET['srch']) && $_GET['srch'] != '') {
                    $query .= " WHERE email LIKE '%" . $_GET['srch'] . "%'";
                }

                $query .= " LIMIT $start_from, $num_per_page";

                $result = mysqli_query($conn, $query);
                $counter = $start_from + 1; // Start numbering from the first record on the current page

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<tr data-id="' . $row['id'] . '">
                                <td>' . $counter . '</td> <!-- Sequential numbering -->
                                <td>' . $row['email'] . '</td>
                              </tr>';
                        $counter++; // Increment counter for each row
                    }
                } else {
                    echo '<tr><td colspan="2">No result!</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <?php
        // Get total number of records
        $qr = "SELECT * FROM tbl_admin";
        $rs_result = mysqli_query($conn, $qr);
        $total_records = mysqli_num_rows($rs_result);
        $total_pages = ceil($total_records / $num_per_page);
        ?>

    </div>
    <div class="pagination float-right" style="font-size: 11px; color: #c7e9c0;">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a id="ac" class="page-link <?php echo ($page <= 1) ? 'disabled' : ''; ?>" 
                       <?php echo ($page > 1) ? 'href="javascript:void(0);" onclick="loadPage(\'admin/admin_side/table.php?page=' . $previous_page . '\',\'maincontent\')"' : ''; ?>>Previous</a>
                </li>

                <?php
                $range = 3;
                $start = max(1, $page - 1);
                $end = min($total_pages, $start + $range - 1);
                $start = max(1, $end - $range + 1);

                for ($counter = $start; $counter <= $end; $counter++) {
                    echo '<li class="page-item' . ($counter == $page ? ' active' : '') . '">
                            <a id="ac" class="page-link" href="javascript:void(0);" onclick="loadPage(\'admin/admin_side/table.php?page=' . $counter . '\',\'maincontent\')">' . $counter . '</a>
                        </li>';
                }
                ?>

                <li class="page-item">
                    <a class="page-link <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>" 
                       <?php echo ($page < $total_pages) ? 'href="javascript:void(0);" id="ac" onclick="loadPage(\'admin/admin_side/table.php?page=' . $next_page . '\',\'maincontent\')"' : ''; ?>>Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="p-10">
        <strong id="bb">Page <?= $page . ' of ' . $total_pages ?></strong>
    </div>
</div>
</div>
