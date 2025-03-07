<?php
$dbconPath = __DIR__ . '/../../../includes/dbcon.php';

if (file_exists($dbconPath)) {
    include_once($dbconPath);
} else {
    die("Error: Unable to include dbcon.php. File not found at: " . $dbconPath);
}
?>

<div class="table-responsive">
    <div class="table-wrapper">
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Fullname</th>
                    <th>Sex</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Course / Instructor</th>
                </tr>   
            </thead>
            <tbody>
                <?php
        
                $num_per_page = 10;
                $page = isset($_GET["page"]) ? $_GET["page"] : 1;
                $start_from = ($page - 1) * $num_per_page;
                $previous_page = $page - 1;
                $next_page = $page + 1;
        
                //Updated SQL query
                $query = "
                    SELECT 
                        users.id AS student_id, 
                        COALESCE(students.fullname, instructors.fullname) AS fullname, 
                        students.sex AS sex, 
                        users.username, 
                        users.email, 
                        COALESCE(students.course, 'Instructor') AS course 
                    FROM users 
                    LEFT JOIN students ON users.id = students.student_id 
                    LEFT JOIN instructors ON users.id = instructors.instructor_id
                    WHERE students.student_id IS NOT NULL";

                //$query = "SELECT a.id, a.email, a.username, b.student_id, b.fullname, b.sex, b.course FROM users a, students b WHERE a.id = b.student_id";

                $whereAdded = true; // Ensure WHERE is accounted for when additional filters are added

                if (isset($_GET['srch']) && $_GET['srch'] != '') {
                    $query .= $whereAdded ? ' AND ' : ' WHERE ';
                    $query .= "(COALESCE(students.fullname, instructors.fullname) LIKE '%" . $_GET['srch'] . "%' 
                                OR users.username LIKE '%" . $_GET['srch'] . "%' 
                                OR users.id LIKE '%" . $_GET['srch'] . "%')";
                    $whereAdded = true;
                }

                if (isset($_GET['type'])) {
                    if ($_GET['type'] == 0) {
                        $query .= $whereAdded ? ' AND ' : ' WHERE ';
                        $query .= "COALESCE(students.course, 'Instructor') = 'Instructor'";
                    } else if ($_GET['type'] == 1) {
                        $query .= $whereAdded ? ' AND ' : ' WHERE ';
                        $query .= "COALESCE(students.course, 'Instructor') != 'Instructor'";
                    }
                }

                $query .= " LIMIT $start_from, $num_per_page";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($rw = mysqli_fetch_array($result)) {
                        echo '<tr>
                                <td>' . $rw['student_id'] . '</td>
                                <td>' . $rw['fullname'] . '</td>
                                <td>' . ($rw['sex'] ?? 'N/A') . '</td>
                                <td>' . $rw['username'] . '</td>
                                <td>' . $rw['email'] . '</td>
                                <td>' . $rw['course'] . '</td>
                              </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No result!</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$qr = "SELECT COUNT(*) AS total FROM users";
$rs_result = mysqli_query($conn, $qr);
$total_records = mysqli_fetch_assoc($rs_result)['total'];
$total_pages = ceil($total_records / $num_per_page);
?>

<div class="pagination float-right" style="font-size: 11px; color: #c7e9c0;">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link <?php echo ($page <= 1) ? 'disabled' : ''; ?>" href="javascript:void(0);" <?php if ($page > 1) echo 'onclick="loadPage(\'admin/pages/users.php?page=' . $previous_page . '\',\'maincontent\')"'; ?>>Previous</a></li>
            <?php
            $range = 3;
            $start = max(1, $page - 1);
            $end = min($total_pages, $start + $range - 1);
            $start = max(1, $end - $range + 1);
            
            for ($counter = $start; $counter <= $end; $counter++) {
                echo '<li class="page-item' . ($counter == $page ? ' active' : '') . '">
                        <a class="page-link" href="javascript:void(0);" onclick="loadPage(\'admin/pages/users.php?page=' . $counter . '\',\'maincontent\')">' . $counter . '</a>
                      </li>';
            }
            ?>
            <li class="page-item"><a class="page-link <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>" href="javascript:void(0);" <?php if ($page < $total_pages) echo 'onclick="loadPage(\'admin/pages/users.php?page=' . $next_page . '\',\'maincontent\')"'; ?>>Next</a></li>
        </ul>
    </nav>
</div>
<div class="p-10">
    <strong id="bb">Page <?= $page . ' of ' . $total_pages ?></strong>
</div>
<br>