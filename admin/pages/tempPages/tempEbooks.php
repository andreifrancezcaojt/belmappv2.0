<?php
$dbconPath = __DIR__ . '/../../../includes/dbcon.php';

if (file_exists($dbconPath)) {
    include_once($dbconPath);
} else {
    die("Error: Unable to include dbcon.php. File not found at: " . $dbconPath);
}

if (isset($_POST['Anid'])) {
    $Anid = $_POST['Anid'];

    mysqli_query($conn, 'UPDATE open_access_db SET is_archived = 1 WHERE id =' . $Anid);
}

if (isset($_POST['Unid'])) {
    $Unid = $_POST['Unid'];

    mysqli_query($conn, 'UPDATE open_access_db SET is_archived = 0 WHERE id =' . $Unid);
}
?>
<style>
    table.table td a {
        color: #fff;
    }
</style>
<div class="table-responsive">
    <div class="table-wrappper">
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Open Access Database Name</th>
                    <th>Category</th>
                    <th>Url</th>
                    <th>Action</th>
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

                $query = "SELECT * FROM open_access_db ";
                $added = false;

                if (isset($_GET['arch'])) {
                    if ($_GET['arch'] != 0) {
                        if ($added) {
                            $query .= ' AND is_archived = ' . $_GET['arch'];
                        } else {
                            $query .= ' WHERE is_archived = ' . $_GET['arch'];
                            $added = true;
                        }
                    }
                }

                if (!$added) {
                    $query .= ' WHERE is_archived = 0';
                    $added = true;
                }

                if (isset($_GET['srch']) && $_GET['srch'] != '') {
                    if ($added) {
                        $query .= " AND (oadb_name LIKE '%" . $_GET['srch'] . "%' OR oadb_url LIKE '%" . $_GET['srch'] . "%')";
                    } else {
                        $query .= " WHERE (oadb_name LIKE '%" . $_GET['srch'] . "%' OR oadb_url LIKE '%" . $_GET['srch'] . "%')";
                        $added = true;
                    }
                }

                $query .= " LIMIT $start_from, $num_per_page";
                $result = mysqli_query($conn, $query);
                $row_number = 1 + $start_from; // Start numbering from 1 per page

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $archive_label = $row['is_archived'] ? "Unarchive" : "Archive";
                        $archive_class = $row['is_archived'] ? "btn-success" : "btn-warning";

                        echo '<tr data-id="' . $row['id'] . '">
                <td>' . $row_number . '</td>
                <td>' . $row['oadb_name'] . '</td>
                <td>' . $row['category'] . '</td>
                <td>' . $row['oadb_url'] . '</td>';

                        if ($row['is_archived'] == 1) {
                            echo '<td>
                    <a class="btn ' . $archive_class . ' btn-sm archive-btn" id="archive-btn-' . $row['id'] . '" onclick="InArchived_ebook(' . $row['id'] . ')">' . $archive_label . '</a>
                  </td>';
                        } else {
                            echo '<td>
                    <div style="display:flex; gap: 3px;">
                        <a class="btn btn-warning btn-sm text-light">
                            <i class="material-icons" data-toggle="tooltip" title="Edit" href="javascript:void(0);" onclick="TINY.box.show({url:\'admin/pages/edit_ebook.php?id=' . $row['id'] . '\',width:400,height:500})">&#xE254;</i>
                        </a>
                        <a class="btn btn-danger btn-sm text-light" href="javascript:void(0);" onclick="OnArchive_ebook(' . $row['id'] . ')">' . $archive_label . '</a>
                    </div>
                  </td>';
                        }
                        echo '</tr>';
                        $row_number++; // Increment the sequential number
                    }
                } else {
                    echo '<tr><td colspan="10">No result!</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <?php
        $qr = "SELECT * from open_access_db";
        $rs_result = mysqli_query($conn, $qr);
        $total_records = mysqli_num_rows($rs_result);
        $total_pages = ceil($total_records / $num_per_page);
        ?>

        <div class="pagination float-right" style="font-size: 11px; color: #c7e9c0;">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a id="ac" class="page-link <?php echo ($page <= 1) ? ' disabled' : ''; ?>"
                            <?php echo ($page > 1) ? 'href="javascript:void(0);" onclick="loadPage(\'admin/pages/e_book.php?page=' . $previous_page . '\',\'maincontent\')"' : ''; ?>>Previous</a>
                    </li>
                    <?php
                    $range = 3;
                    $start = max(1, $page - 1);
                    $end = min($total_pages, $start + $range - 1);
                    $start = max(1, $end - $range + 1);

                    for ($counter = $start; $counter <= $end; $counter++) {
                        echo '<li class="page-item' . ($counter == $page ? ' active' : '') . '">
                        <a id="ac" class="page-link" href="javascript:void(0);" onclick="loadPage(\'admin/pages/e_book.php?page=' . $counter . '\',\'maincontent\')">' . $counter . '</a>
                      </li>';
                    }
                    ?>
                    <li class="page-item">
                        <a class="page-link <?php echo ($page >= $total_pages) ? ' disabled' : ''; ?>"
                            <?php echo ($page < $total_pages) ? 'href="javascript:void(0);" onclick="loadPage(\'admin/pages/e_book.php?page=' . $next_page . '\',\'maincontent\')"' : ''; ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="p-10">
            <strong id="bb">Page <?= $page . ' of ' . $total_pages ?></strong>
        </div>

    </div>
</div>