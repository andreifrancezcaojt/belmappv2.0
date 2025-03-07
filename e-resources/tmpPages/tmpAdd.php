<?php
// Include database connection
$dbconPath = __DIR__ . '/../../includes/dbcon.php';

if (file_exists($dbconPath)) {
    include_once($dbconPath);
} else {
    die("Error: Unable to include dbcon.php. File not found at: " . $dbconPath);
}

if (isset($_POST['Aid'])) {
    $Aid = (int) $_POST['Aid']; // Sanitize input
    mysqli_query($conn, "UPDATE pdf_file SET is_archived = 1 WHERE id = $Aid");
}

if (isset($_POST['Uid'])) {
    $Uid = (int) $_POST['Uid']; // Sanitize input
    mysqli_query($conn, "UPDATE pdf_file SET is_archived = 0 WHERE id = $Uid");
}

// Pagination setup
$num_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $num_per_page;

// Build query with filters
$query = "SELECT * FROM pdf_file";
$conditions = [];

if (isset($_GET['arch']) && $_GET['arch'] != 0) {
    $conditions[] = "is_archived = " . (int)$_GET['arch'];
} else {
    $conditions[] = "is_archived = 0"; // Default: show non-archived
}

// Search by selected column
if (isset($_GET['srch']) && $_GET['srch'] !== '' && isset($_GET['col']) && $_GET['col'] !== '') {
    $search = mysqli_real_escape_string($conn, $_GET['srch']);
    $column = mysqli_real_escape_string($conn, $_GET['col']);

    $conditions[] = "$column LIKE '%$search%'";
}

// Combine conditions and add pagination
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}
$query .= " LIMIT $start_from, $num_per_page";

$result = mysqli_query($conn, $query);
?>

<!-- Table to display PDF files -->
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Call No.</th>
            <th>E-Resource Title</th>
            <th>File Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php
        $counter = $start_from + 1; // Start numbering from the first item on the current page
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $archive_label = $row['is_archived'] ? "Unarchive" : "Archive";
                $archive_class = $row['is_archived'] ? "btn-success" : "btn-danger";
        ?>
                <tr data-id="<?= $row['id']; ?>">
                    <td><?= $counter++; ?></td> <!-- Use the counter for numbering -->
                    <td><?= htmlspecialchars($row['pdf_callnumber']); ?></td>
                    <td><?= htmlspecialchars($row['pdf_name']); ?></td>
                    <td><?= htmlspecialchars($row['pdf']); ?></td>
                    <td><?= htmlspecialchars($row['category']); ?></td>
                    <td>
                        <?php if ($row['is_archived']): ?>
                            <a class="btn <?= $archive_class; ?> btn-sm text-light"
                                onclick="unArchived_pdf(<?= $row['id']; ?>)">
                                <?= $archive_label; ?>
                            </a>
                        <?php else: ?>
                            <div style="display: flex; gap: 3px;">
                                <a class="btn btn-warning btn-sm text-light"
                                    onclick="TINY.box.show({url:'e-resources/add_pdf.php?id=<?= $row['id']; ?>',width:400,height:450})">
                                    <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                </a>
                                <a class="btn <?= $archive_class; ?> btn-sm text-light"
                                    onclick="archive_pdf(<?= $row['id']; ?>)">
                                    <?= $archive_label; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="6">No results found!</td></tr>';
        }
        ?>

    </tbody>
</table>

<!-- Pagination -->
<?php
$total_query = "SELECT COUNT(*) AS total FROM pdf_file";
if (!empty($conditions)) {
    $total_query .= " WHERE " . implode(" AND ", $conditions);
}
$total_result = mysqli_query($conn, $total_query);
$total_records = $total_result ? mysqli_fetch_assoc($total_result)['total'] : 0;
$total_pages = ceil($total_records / $num_per_page);
?>
<div class="pagination float-right" style="font-size: 11px; color: #c7e9c0;">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link"
                    <?= $page > 1 ? 'onclick="loadPage(\'e-resources/add.php?page=' . ($page - 1) . '\',\'maincontent\')"' : ''; ?>>
                    Previous
                </a>
            </li>
            <?php
            $range = 3;
            $start = max(1, $page - 1);
            $end = min($total_pages, $start + $range - 1);

            $start = max(1, $end - $range + 1);

            for ($counter = $start; $counter <= $end; $counter++) {
                echo '<li class="page-item' . ($counter == $page ? ' active' : '') . '">
                        <a class="page-link" 
                           onclick="loadPage(\'e-resources/add.php?page=' . $counter . '\',\'maincontent\')">
                            ' . $counter . '
                        </a>
                      </li>';
            }
            ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link"
                    <?= $page < $total_pages ? 'onclick="loadPage(\'e-resources/add.php?page=' . ($page + 1) . '\',\'maincontent\')"' : ''; ?>>
                    Next
                </a>
            </li>
        </ul>
    </nav>
</div>
<div class="p-10">
    <strong id="bb">Page <?= $page . ' of ' . $total_pages; ?></strong>
</div>