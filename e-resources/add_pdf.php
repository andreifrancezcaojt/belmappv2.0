<?php
include('../includes/dbcon.php');
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $pdf = get("SELECT pdf FROM pdf_file WHERE id = '$id'");
    $pdf_name = get("SELECT pdf_name FROM pdf_file WHERE id = '$id'");
}
?>
<div class="container">
  <div class="row">
    <div class="col">
      <form class="needs-validation" value="<?=$id?>" method="POST" id="form" enctype="multipart/form-data" novalidate>
        <center><h2 class="mb-4">Edit E-Resource</h2></center>
        <hr>
        <div class="form-group">
          <input type="hidden" id="xxx">
          <input type="hidden" id="id" value="<?php echo $id; ?>">
          <label for="pdf" class="form-label">Choose a file to upload (Only PDF format allowed):</label>
          <input type="file" value="<?=$pdf?>" class="form-control" id="pdf" required>
          <div class="invalid-feedback">Please choose a PDF file.</div>
        </div><br>
        <div class="form-group">
          <label for="pdf_name" class="form-label">Enter PDF name:</label>
          <input type="text" value="<?=$pdf_name?>" class="form-control" id="pdf_name" name="pdf_name" required>
          <div class="invalid-feedback">Please enter a PDF name.</div>
        </div><br>
        <div class="form-group">
          <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="edit_pdf();">Update</a>
        </div>
      </form>
    </div>
  </div>
</div>
  