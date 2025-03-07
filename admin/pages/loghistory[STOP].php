<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../../includes/dbcon.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log History</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Assuming you have a stylesheet -->
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <style>
        body {
            padding-top: 0px;
            color: #566787;
            background: #f5f5f5;
        }

        .table-responsive {
            margin: 30px 0;
            height: 250px;
            overflow-y: auto;
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
</head>

<body>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>Most Frequent User </b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Login Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        $q = 'SELECT a.id, a.username, COUNT(b.user_id) AS login_count
                          FROM users a
                          JOIN login_history b ON a.id = b.user_id
                          GROUP BY a.id, a.username;';
                        $rs = mysqli_query($conn, $q);

                        while ($row = mysqli_fetch_array($rs)) {
                            echo '<tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['login_count'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br>

        <h4>Log in time of users</h4>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $c = 1;
                    $q = 'SELECT a.id, a.username, b.login_time
                      FROM users a
                      JOIN login_history b ON a.id = b.user_id';
                    $rs = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_array($rs)) {
                        echo '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['username'] . '</td>
                            <td>' . $row['login_time'] . '</td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>