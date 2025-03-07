<?php
include_once('../includes/dbcon.php'); // Include your database connection

// Set header for JSON response
header('Content-Type: application/json');

// Check if feedback_url is set in the POST request
if (isset($_POST['feedback_url'])) {
     $feedback_url = mysqli_real_escape_string($conn, $_POST['feedback_url']); // Sanitize input

     mysqli_query($conn, "INSERT INTO feedback_qr (feedback_url) VALUES ('$feedback_url')");
}

$url = get("SELECT feedback_url FROM feedback_qr");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Feedback Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<div class="container">
    <div class="row">
        <div class="col">
            <?php
            if($url){
                echo '<br><br><br><br><br><br><center><span style="font-size: 35px; color: red;">You Already have a URL!</span></center>';
            }else{
                echo '
                    <form id="feedbackForm" method="post" enctype="multipart/form-data">
                    <h2><center>Add a Feedback Form</center></h2>
                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <label for="feedback_url">Enter the feedback URL:</label>
                            <div class="col">
                                
                                <input class="form-control" type="text" id="feedback_url" name="feedback_url" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                            <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="add_feedback();">ADD</a>
                            </div>
                        </div>
                    </div>
                </form>';
                    
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>


