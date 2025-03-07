<?php
session_start();
include_once('../../includes/dbcon.php');

$link = get('SELECT opac_link from opac');

?>

<form>
  <div class="mb-3" id="add_opac">
    <?php
        if($link){
            echo '<br><br><br><br><br><br><center><span style="font-size: 35px; color: red;">You Already have a URL!</span></center>';
        }else{
            echo '
            <label for="opac_link" class="form-label">Add Opac Link</label>
            <input type="opac_link" class="form-control" id="opac_link">
            <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="add_opac()">Add Opac Link</a>
          ';

        }
    
    ?>
</form>


