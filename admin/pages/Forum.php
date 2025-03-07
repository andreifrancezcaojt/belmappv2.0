<?php
session_name('admin_session');
session_start();
include_once('../../includes/dbcon.php');

$num_per_page = 10;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $num_per_page;
$query = "SELECT * from threads limit $start_from, $num_per_page";
$result = mysqli_query($conn, $query);

// if (isset($_GET['delId'])) {
//     $id = intval($_GET['delId']);
//     $delete_query = "DELETE FROM threads WHERE id = $id";
//     mysqli_query($conn, $delete_query);
// }

//to follow mapupunta sa archive.....
if(isset($_GET['CommentId'])){
    $id = $_GET['CommentId'];
    mysqli_query($conn, 'DELETE FROM replies WHERE id ='.$id);
}

if(isset($_GET['delThread'])){
    $id = $_GET['delThread'];
     mysqli_query($conn, 'DELETE FROM threads WHERE id ='.$id);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">






</head>
<body>
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
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .table-title {
            padding-bottom: 15px;
            background: lightseagreen;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }
        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }
        .table-title .btn-group {
            float: right;
        }
        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }
        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }
        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }
        table.table tr th, table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }
        table.table tr th:first-child {
            width: 60px;
        }
        table.table tr th:last-child {
            width: 100px;
        }
        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }
        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }
        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }    
        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }
        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }
        table.table td a:hover {
            color: #2196F3;
        }
        table.table td i {
            font-size: 19px;
        }
        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }
    </style>

    <!-- <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>FORUM</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>User_ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $q = 'SELECT * FROM threads';
                    $rs = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_array($rs)) {
                        echo '<tr>
                                <td>'.$row['user_id'].'</td>
                                <td>'.$row['title'].'</td>
                                <td>'.$row['content'].'</td>
                                <td>'.$row['created_at'].'</td>
                                <td>
                                <div style="display:flex; gap: 3px;">
                                    <a class="btn btn-danger btn-sm"><i class="material-icons" data-toggle="tooltip" title="Delete" onclick="delete_forum('.$row['id'].')">&#xE872;</i></a>
                                </div>
                            </td>
                              </tr>';
                    }
                    ?>
                    
                    </tbody>
                </table>
                <?php
                $qr = "SELECT * from threads";
                $rs_result = mysqli_query($conn, $qr);
                $total_records = mysqli_num_rows($rs_result);
                $total_pages = ceil($total_records / $num_per_page);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a class="btn btn-primary btn-sm" style="margin-right: 5px;" href="admin/pages/Forum.php?page='.$i.'">'.$i.'</a>';
                }
                ?>
            </div>
        </div>
    </div> -->
    <div class="container-fluid">
    <div class="card shadow">
       <div class="card-title text-white" style="background-color: #33c430cf;">
            <h3 class="p-2 fw-bold ml-3 mt-2">Forum</h3>
        </div>

        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php
                $q = mysqli_query($conn, "SELECT * FROM threads");
                while($rw = mysqli_fetch_array($q)){
                    $threadId = $rw['id'];
                    $threadTitle = $rw['title'];
                    $threadContent = $rw['content'];
                    $creator = get('SELECT username FROM users WHERE id='.$rw['user_id']);
                    
                    $collapseId = "flush-collapse-".$threadId;

                    echo '
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="heading-'.$threadId.'">
                                <input type="hidden" id="threadId" value="'.$threadId.'">
                                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#'.$collapseId.'" aria-expanded="false" aria-controls="'.$collapseId.'">
                                    <strong>Title: &nbsp; </strong>'.$threadTitle.'
                                </button>
                            </h2>
                            <div id="'.$collapseId.'" class="accordion-collapse collapse" aria-labelledby="heading-'.$threadId.'" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body bg-white shadow-sm p-3">
                                    <table width="100%">
                                        <tr>
                                            <td width="95%">
                                                <strong>Thread Content:</strong> '.$threadContent.'<br><br>
                                            </td>
                                            <td width="5%">
                                                <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete" onclick="delete_thread('.$threadId.')">
                                                    <i class="material-icons">&#xE872;</i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <h6><strong>Created by: '.$creator.'</strong> on '.$rw['created_at'].'</h6>';

                    $qrep = mysqli_query($conn, 'SELECT * FROM replies WHERE thread_id = '.$threadId);
                    while($rrr = mysqli_fetch_array($qrep)){
                        $replyN = get('SELECT username FROM users WHERE id ='.$rrr['user_id']);

                        echo '
                            <table width="100%" class="mt-3">
                                <tr>
                                    <td width="90%">
                                        <div class="reply bg-light p-2 rounded">
                                            <strong>Created by: '.$replyN.' on '.$rrr['created_at'].'</strong><br>
                                            <strong>Reply:</strong> '.$rrr['content'].'
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <a class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete" onclick="delete_comment('.$rrr['id'].')">
                                            <i class="material-icons">&#xE872;</i>
                                        </a>
                                    </td>
                                </tr>
                            </table>';
                    }

                    echo '</div></div></div>'; // Close accordion-collapse, accordion-body, and accordion-item
                }
                ?>
            </div> <!-- Close accordion -->
        </div>
    </div>
</div>


    <!-- <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                Accordion Item #2
            </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                Accordion Item #3
            </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
            </div>
        </div>
        </div> -->
    <!-- Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>
