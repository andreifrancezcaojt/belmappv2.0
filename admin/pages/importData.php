<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS link -->
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
    <!-- Import Excel file -->
    <div class="container">
        <div class="row">

            <div class="col">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h4 class="text-success fw-bold">STUDENTS</h4>
                                    <h5 class="text-center mb-1">Import Students List</h5>
                                    <p class="text-center">Click the button below to import the excel file of the list of students.</p><br>

                                    <!-- Button to trigger the export -->
                                    <form action="admin/pages/import_students.php" method="post" enctype="multipart/form-data" class="d-flex justify-content-center">
                                        <input type="file" name="excelFile" accept=".xls,.xlsx" required>
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-upload"></i> Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h4 class="text-success fw-bold">INTRUCTORS</h4>
                                    <h5 class="text-center mb-1">Import Instructors List</h5>
                                    <p class="text-center">Click the button below to import the excel file of the list of students .</p><br>

                                    <!-- Button to trigger the export -->
                                    <form action="admin/pages/import_instructors.php" method="post" enctype="multipart/form-data" class="d-flex justify-content-center">
                                        <input type="file" name="excelFile" accept=".xls,.xlsx" required>
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-upload"></i> Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>






</body>

</html>