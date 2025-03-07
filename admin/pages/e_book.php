<?php
include('../../includes/dbcon.php');

if(isset($_GET['get_oadb'])){
    if(isset($_POST['yyy'])){
        $oadb_name = $_POST['oadb'];
        $url = $_POST['url'];
        $category = $_POST['category'];
        if(isset($_FILES['pic'])){
            $target_dir = "../../uploadedDB/";
            $Image = basename($_FILES["pic"]["name"]);
            $target_file = $target_dir . $Image;
            if(move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)){
                mysqli_query($conn, "INSERT INTO open_access_db (oadb_name, image, oadb_url, category) VALUES ('$oadb_name','$Image','$url','$category')" );
            }else {}
        }else {$Image = '';}
    }
}

if(isset($_GET['edit_oadb'])){
    if(isset($_POST['yyy'])){
        $id = $_POST['id'];
        $oadb_name = $_POST['oadb'];
        $oadb_url = $_POST['url'];
        $category = $_POST['category'];

        if(isset($_FILES['pic'])){
            $target_dir = "../../uploadedDB/";
            $Image = basename($_FILES["pic"]["name"]);
            $target_file = $target_dir . $Image;
            if(move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)){
                mysqli_query($conn, "UPDATE open_access_db SET oadb_name = '$oadb_name', image = '$Image', oadb_url = '$oadb_url', category = '$category' WHERE id = '$id'" );
            }else {}
        }else {$Image = '';}
    }
}

if(isset($_GET['delId'])){
    $id = $_GET['delId'];
    mysqli_query($conn, "DELETE FROM open_access_db WHERE id = $id");
}

if(isset($_GET['edit_pdf'])){
    $id = $_GET['edit_pdf'];
    mysqli_query($conn, "UPDATE open_access_db SET (oadb_name, image, oadb_url, category) VALUES ('$oadb_name','$Image', '$url', '$category')" );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Database</title>
    <!-- Bootstrap CSS link -->
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
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {        
		padding-bottom: 15px;
		background: #33c430cf;
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

</head>
<body>

<?php
    $script = "loadPage('admin/pages/tempPages/tempEbooks.php?srch='+document.getElementById('srch').value
                                                                +'&arch='+document.getElementById('arch').value,'tempo')";
?>

<div class="container-fluid ">
<div class="table-responsive shadow  mb-5 bg-white rounded">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-xs-6">
                    <h2><b>Open Access Database</b></h2>
                </div>
                <div class="col-xs-6">
                    <a href="javascript:void(0);" onclick="TINY.box.show({url:'admin/pages/add_ebook.php',width:400,height:550})" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New</span></a>
                </div>
            </div>
        </div>
        
        <div class="float-right p-1">
        <input type="text" placeholder="Search..." id="srch" onkeyup="<?php echo $script; ?>">

        <select name="" id="arch" onchange="<?php echo $script?>">
            <option value="0">All</option>
            <option value="1">Archived</option>
        </select>
    </div>


<div id="tempo"><?php include('tempPages/tempEbooks.php');?></div>

<!-- Bootstrap JS and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
