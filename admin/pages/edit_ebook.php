<?php
include('../../includes/dbcon.php');
$id = $_GET['id'];

$oadb = get("SELECT oadb_name FROM open_access_db WHERE id = '$id'");
$image = get("SELECT image FROM open_access_db WHERE id = '$id'");
$oadb_url = get("SELECT oadb_url FROM open_access_db WHERE id = '$id'");
$category = get("SELECT category FROM open_access_db WHERE id = '$id'");

?>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" enctype="multipart/form-data" id="form">
                <input type="hidden" value="<?=$id?>" id="id" name="id">
                <h2><center>Edit Open Access Database</center></h2>
                <hr>

                <div class="form-group">
                    <div class="row">
                        <label>Enter open access database name:</label>
                        <div class="col">
                            <input class="form-control" value="<?=$oadb?>" type="text" name="oadb_name" id="oadb" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label>Select Category:</label>
                        <div class="col">
                            <select class="form-control" name="category" id="category" required>
                                <option value="free" <?= $category === 'free' ? 'selected' : '' ?>>Free</option>
                                <option value="paid" <?= $category === 'paid' ? 'selected' : '' ?>>Paid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" id="yyy">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" value="<?=$image?>" name="image" id="pic" required accept="image/*">
                            <span style="color: dark; font-size: 14px;"><center>Only jpg / jpeg/ png /gif format allowed.</center></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label>Enter open access database URL:</label>
                        <div class="col"><input class="form-control" value="<?=$oadb_url?>" type="text" name="oadb_url" id="url" required></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="edit_oadb();">Update</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
 </div>