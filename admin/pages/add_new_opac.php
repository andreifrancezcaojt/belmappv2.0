<?php
include_once('../../includes/dbcon.php');

// Function to get OPAC data
function getOpacData($conn) {
    $query = "SELECT id, opac_link FROM opac"; // Query to fetch id and opac_link
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }
    
    return $result; // Return the result set
}

$result = getOpacData($conn); // Call the function to get data

// if(isset($_POST['opac_link'])){

//     $id = mysqli_real_escape_string($conn, $_POST['id']);
//     $opac_link = mysqli_real_escape_string($conn, $_POST['opac_link']);

//     // Update query
//     $query = "UPDATE opac SET opac_link = '$opac_link' WHERE id = '$id'";

//     if (mysqli_query($conn, $query)) {
//         // echo "Update successful"; // Respond with a success message
//     } else {
//         // echo "Error updating record: " . mysqli_error($conn); // Display error message
//     }
// }

if(isset($_POST['opac_link'])){
    $link = $_POST['opac_link'];

    mysqli_query($conn, "INSERT INTO opac (opac_link) VALUES ('$link')");
}

if(isset($_POST['new_link'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $new_link = mysqli_real_escape_string($conn, $_POST['new_link']);

    $query = mysqli_query($conn, "UPDATE opac SET opac_link = '$new_link' WHERE id = '$id'");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change OPAC Link</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
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

<?php
    $script = "loadPage('admin/pages/tempPages/tempOpac.php?srch='+document.getElementById('srch').value,'tempo')";
?>

<div class="container-fluid">
<div class="table-responsive shadow  mb-5 bg-white rounded">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-xs-6">
                    <h2><b>Change OPAC Link</b></h2>
                </div>
                <div class="col-xs-6">
                    <a href="javascript:void(0);" onclick="TINY.box.show({url:'admin/pages/add_opac_link.php',width:400,height:450})" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New</span></a>
                </div>
            </div>
        </div>

    <div class="float-right p-1">
        <input type="text" placeholder="Search..." id="srch" onkeyup="<?php echo $script; ?>">
    </div>

<div id="tempo"><?php include('tempPages/tempOpac.php');?></div>