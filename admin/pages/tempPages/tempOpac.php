<?php
$dbconPath = __DIR__ . '/../../../includes/dbcon.php';

if (file_exists($dbconPath)) {
    include_once($dbconPath);
} else {
    die("Error: Unable to include dbcon.php. File not found at: " . $dbconPath);
}
?>
<style>
    table.table td a {
        color: #fff;
    }
</style>
<table class="table table-striped " id="myTable">
    <thead>
        <tr>
            <th>#</th>
            <th>OPAC Link</th>
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

        $q = "SELECT * FROM opac";

        if (isset($_GET['srch'])) {
            if ($_GET['srch'] != '') {
                $q .= ' WHERE (opac_link LIKE \'%' . $_GET['srch'] . '%\')';
            }
        }

        $q .= " LIMIT $start_from, $num_per_page";

        //echo $q;

        $rs = mysqli_query($conn, $q);
        if (mysqli_num_rows($rs) > 0) {
            while ($rw = mysqli_fetch_array($rs)) {
                echo '<tr>
                        <td>' . $rw['id'] . '</td>
                        <td>' . $rw['opac_link'] . '</td>
                        <td>
                            <div style="display:flex; gap: 3px;">
                                <a class="btn btn-warning btn-sm text-light" href="javascript:void(0);" onclick="TINY.box.show({url:\'admin/pages/edit_opac.php?id=' . $rw['id'] . '\',width:400,height:450})"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                </a>
                            </div>
                        </td>
                    </tr>';
            }
        } else {
            echo '<tr><td colspan="10">No result!</td></tr>';
        }
        ?>
    </tbody>
</table>
<?php
$qr = "SELECT * FROM opac";
$rs_result = mysqli_query($conn, $qr);
$total_records = mysqli_num_rows($rs_result);
$total_pages = ceil($total_records / $num_per_page);

?>
<div class="pagination float-right" style="font-size: 11px; color: #c7e9c0;">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a id="ac" class="page-link
            <?php echo ($page <= 1) ? ' disabled' : ''; ?> "
                    <?php echo ($page > 1) ? 'href="javascript:void(0);" onclick="loadPage(\'admin/pages/add_new_opac.php?page=' . $previous_page . '\',\'maincontent\')"' : ''; ?>>Previous</a></li>

            <?php
            $range = 3;
            $start = max(1, $page - 1);
            $end = min($total_pages, $start + $range - 1);

            $start = max(1, $end - $range + 1);

            for ($counter = $start; $counter <= $end; $counter++) {
                echo '<li class="page-item' . ($counter == $page ? ' active' : '') . '">
                            <a id="ac" class="page-link" href="javascript:void(0);" onclick="loadPage(\'admin/pages/add_new_opac.php?page=' . $counter . '\',\'maincontent\')">' . $counter . '</a>
                        </li>';
            }
            ?>
            <li class="page-item"><a class="page-link 
            <?php echo ($page >= $total_pages) ? ' disabled' : ''; ?>"
                    <?php echo ($page < $total_pages) ? 'href="javascript:void(0);" id="ac" onclick="loadPage(\'admin/pages/add_new_opac.php?page=' . $next_page . '\',\'maincontent\')"' : ''; ?>>Next</a></li>
            </li>
        </ul>
    </nav>
</div>
<div class="p-10">
    <strong id="bb">Page <?= $page . ' of ' . $total_pages ?></strong>
</div>

</div>
</div>
</div>