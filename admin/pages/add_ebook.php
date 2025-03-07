<?php

include_once('../../includes/dbcon.php');

if (isset($_POST['addDatabase'])) {
    $oadb_name = mysqli_real_escape_string($conn, $_POST['oadb_name']);
    $oadb_url = mysqli_real_escape_string($conn, $_POST['oadb_url']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);  

    $image = $_FILES["image"]["name"];

    // Get the image extension
    $extension = substr($image, strlen($image) - 4, strlen($image));

    // Allowed extensions
    $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");

    // Validation for allowed extensions using in_array()
    if (!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    } else {
        // Rename the image file
        $imgnewfile = md5($image) . time() . $extension;

        // Code for moving the image into the directory
        move_uploaded_file($_FILES["image"]["tmp_name"], "../uploadedDB/" . $imgnewfile);

        // Insert data into the database, including the category
        $query = "INSERT INTO open_access_db (oadb_name, oadb_url, image, category)
                  VALUES ('$oadb_name', '$oadb_url', '$imgnewfile', '$category')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header('Location: adddatabase.php');
        } else {
            echo "<script>alert('Error adding database');</script>";
        }
    }
}
?>


<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" enctype="multipart/form-data" id="form">
                <h2>
                    <center>Add Open Access Database</center>
                </h2>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <label>Enter open access database name:</label>
                        <div class="col"><input class="form-control" type="text" name="oadb_name" id="oadb" required></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label>Select Category:</label>
                        <div class="col">
                            <select class="form-control" name="category" id="category" required>
                                <option value="free">Free</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" id="yyy">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" name="image" id="pic" required accept="image/*">
                            <span style="color: dark; font-size: 14px;">
                                <center>Only jpg / jpeg/ png /gif format allowed.</center>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label>Enter open access database URL:</label>
                        <div class="col"><input class="form-control" type="text" name="oadb_url" id="url" required></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="upload_oadb();">ADD</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>