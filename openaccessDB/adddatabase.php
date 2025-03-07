<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Database</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    
<div class="container">
    <div class="row">
        <div class="col">
            <form action="adddatabase.php" method="post" enctype="multipart/form-data">
                <h2><center>Add Open Access Database</center></h2>
                <hr>

                <div class="form-group">
                    <div class="row">
                        <label>Enter open access database name:</label>
                        <div class="col"><input class="form-control" type="text" name="oadb_name" required></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" name="image"  required = "true">
                            <span style="color:dark; font-size:14px;"><center>Only jpg / jpeg/ png /gif format allowed.</center></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label>Enter open access database url:</label>
                        <div class="col"><input class="form-control" type="text" name="oadb_url" required></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <center><button type="submit" name="addDatabase" class="btn btn-primary">ADD</a></center>
                        </div>
                    </div>
                </div>

                <?php

                    include_once('../includes');

                        if(isset($_POST['addDatabase'])){

                            $oadb_name = mysqli_real_escape_string($conn, $_POST['oadb_name']);
                            $oadb_url = mysqli_real_escape_string($conn, $_POST['oadb_url']);

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

                                // Insert data into the database
                                $query = "INSERT INTO open_access_db (oadb_name,oadb_url, image)
                                VALUES ('$oadb_name', '$oadb_url','$imgnewfile')";
                                $result = mysqli_query($conn, $query);
                                header('Location: adddatabase.php');
                            }
                        }

                    ?>
                
            </form>
        </div>
    </div>
</div>


    <!-- Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>