<?php
session_name('admin_session');
session_start();
include_once('../../includes/dbcon.php');

if(isset($_GET['get_url'])){
    if(isset($_POST['yyy'])){
        $url = $_POST['url'];
        if(isset($_FILES['bookImage'])){
            $target_dir = "../../uploads/";
            $bookImage = basename($_FILES["bookImage"]["name"]);
            $target_file = $target_dir . $bookImage;
            if(move_uploaded_file($_FILES["bookImage"]["tmp_name"], $target_file)){
                mysqli_query($conn, "INSERT INTO tbl_ebook (url, image) VALUES ('$url','$bookImage')" );
            }else {}
        }else {$bookImage = '';}
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EBook</title>
</head>
<body>
    <table>
        <tr>
            <td><input type="text" placeholder="Search....."></td>
            <td style="position: absolute; right: 0;"><a href="javascript:void(0);" onclick="TINY.box.show({url:'admin/pages/new_ebook.php',width:400,height:400})" class="btn btn-success">Add New</a></td>
        </tr>
    </table>
    <div id="tmp_tmp">
        <?php include('tmp_ebook.php');
        ?>
    </div>
</body>
</html>