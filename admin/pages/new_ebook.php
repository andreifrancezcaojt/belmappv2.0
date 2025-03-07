<?php
session_name('admin_session');
session_start();
include_once('../../includes/dbcon.php');

?>

<form method="POST" id="form">
    <div class="mb-3" style="font-weight: bold;">
        <label for="url" class="form-label">Url:</label>
        <input type="text" class="form-control" id="url" name="url" placeholder="Url of E-Book" />

        <label for="bookImage">Upload Image:</label>
        <input hidden type="text" id="yyy" name="yyy">
        <input type="file" id="bookImage" name="bookImage" />
        <button type="button" class="btn btn-info" onclick="upload_book()" >Upload</button>
    </div>
</form>

<div class="container-fluid" id="newAdmin">
    <form method="POST" >
        <div class="mb-3" style="font-weight: bold;">
            <label for="url" class="form-label">Url:</label>
            <input type="text" class="form-control" id="url" placeholder="Url of E-Book" />

            <label for="bookImage">Upload Image:</label>
            <input type="file" id="bookImage" name="bookimage" />
            <button type="button" class="btn btn-info" onclick="upload_book();" id="FormData">Upload</button>
        </div>
    </form>
</div>

<div class="container-fluid" id="newAdmin">
<form>
         <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="text" class="form-control" id="url">
        </div> 

   <button type="button" class="btn btn-success" onclick="add_book()">Add</button> 
     <div class="mb-3" style="font-weight: bold;">
    <label for="Url" class="form-label">Url:</label>
    <input hidden type="text" id="yyy" name="yyy" />
    <input type="text" class="form-control" id="url" placeholder="Url of E-Book" />

    <label for="">Upload Image:</label>
    <input type="file" id="bookImage" name="bookimage" />
    <button class="btn btn-info" onclick="upload_book();" id="FormData">Upload</button>
    </div>
</form>
</div> 

 <form id="uploadForm" enctype="multipart/form-data">
    <input type="url" name="url" placeholder="Enter URL">
    <input type="file" name="pictures" multiple accept="image/*">
    <button type="button" onclick="uploadFormData()">Upload</button>
</form>



