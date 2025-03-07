<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
    body {
        padding-top: 0px;
        color: #566787;
		background: #f5f5f5;
	}

</style>
</head>
<body>

<!-- Export Excel file -->

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-body">
                <h4 class="text-success fw-bold">User</h4>
                    <h5 class="text-center mb-1">Export User Data</h5>
                    <p class="text-center">Click the button below to export users data in Excel format.</p>

                    <!-- Button to trigger the export -->
                    <form action="admin/pages/export_users.php" method="post" class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-md">
                        <i class="fa fa-download"></i> Download</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-body">
                <h4 class="text-success fw-bold">Open Access Database</h4>
                    <h5 class="text-center mb-1">Export Open Access Database</h5>
                    <p class="text-center">Click the button below to export database in Excel format.</p>

                    <!-- Button to trigger the export -->
                    <form action="admin/pages/export_oadb.php" method="post" class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-md">
                        <i class="fa fa-download"></i> Download</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <div class="card shadow">
                <div class="card-body">
                <h4 class="text-success fw-bold">E-resources</h4>
                    <h5 class="text-center mb-1">Export E-resources</h5>
                    <p class="text-center">Click the button below to export e-resources data in Excel format.</p>

                    <!-- Button to trigger the export -->
                    <form action="admin/pages/export_e-resources.php" method="post" class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-md">
                        <i class="fa fa-download"></i> Download</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>


</body>
</html>

