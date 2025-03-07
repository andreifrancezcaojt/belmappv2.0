<?php
include_once('../includes/dbcon.php');

// Handle file upload
if (isset($_GET['upload_pdf'])) {
    if (isset($_POST['xxx'])) {
        $pdf_name = $_POST['pdf_name'];
        $pdf_callnumber = $_POST['pdf_callnumber'];
        if (isset($_FILES['pdf'])) {
            $target_dir = "../pdf";
            $pdf = basename($_FILES["pdf"]["name"]);
            $target_file = $target_dir . $pdf;
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
                mysqli_query($conn, "INSERT INTO pdf_file (pdf_name, pdf,pdf_callnumber) VALUES ('$pdf_name','$pdf','$pdf_callnumber')");
            }
        }
    }
}

if (isset($_GET['edit_pdf'])) {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $pdf_name = $_POST['pdf_name'];

        // Check if a file was uploaded
        if (isset($_FILES['pdf'])) {
            $target_dir = "../pdf/"; // Directory to store PDF
            $pdf = basename($_FILES["pdf"]["name"]);
            $target_file = $target_dir . $pdf;

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
                // If the file upload succeeds, update the PDF record in the database
                $sql = "UPDATE pdf_file SET pdf_name = '$pdf_name', pdf = '$pdf' WHERE id = '$id'";

                if (mysqli_query($conn, $sql)) {
                    echo "PDF updated successfully!";
                } else {
                    echo "Error updating PDF: " . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            // If no file is uploaded, just update the pdf_name
            $sql = "UPDATE pdf_file SET pdf_name = '$pdf_name' WHERE id = '$id'";

            if (mysqli_query($conn, $sql)) {
                echo "PDF name updated successfully!";
            } else {
                echo "Error updating PDF name: " . mysqli_error($conn);
            }
        }
    }
}

// Handle delete request
if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    mysqli_query($conn, "DELETE FROM pdf_file WHERE id = $id");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Database</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

    <?php
    $script = "loadPage('e-resources/tmpPages/tmpAdd.php?srch='+document.getElementById('srch').value
            +'&arch='+document.getElementById('arch').value
            +'&col='+document.getElementById('searchColumn').value,'tempo')";
    ?>

    <div class="container">
        <div class="table-responsive shadow">
            <div class="table-wrapper">
                <div class="table-title" style="background-color: #33c430cf;">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2><b>E-Resources</b></b></h2>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0);" onclick="TINY.box.show({url:'e-resources/test_pdf.php',width:400,height:550})" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New</span></a>
                        </div>
                    </div>
                </div>

                <div class="float-right p-1">
                    <select id="searchColumn" onchange="<?php echo $script; ?>">
                        <option value="pdf_callnumber">Call No.</option>
                        <option value="pdf_name">E-Resource Title</option>
                        <option value="pdf">Filename</option>
                        <option value="category">Category</option>
                    </select>

                    <input type="text" placeholder="Search..." id="srch" onkeyup="<?php echo $script; ?>">

                    <select id="arch" onchange="<?php echo $script; ?>">
                        <option value="0">All</option>
                        <option value="1">Archived</option>
                    </select>
                </div>

                <div id="tempo"><?php include('tmpPages/tmpAdd.php'); ?></div>




                <!-- Bootstrap JS and jQuery scripts -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="js/bootstrap.bundle.min.js"></script>
                <script>
                    function delete_pdf(id) {
                        if (confirm('Are you sure you want to delete this PDF?')) {
                            window.location.href = 'add.php?delId=' + id;
                        }
                    }

                    // Enable Bootstrap validation
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            var forms = document.getElementsByClassName('needs-validation');
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>
</body>

</html>