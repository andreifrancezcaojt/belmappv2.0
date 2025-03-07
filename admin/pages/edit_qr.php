<?php
include('../../includes/dbcon.php');

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $qr_link = get('SELECT feedback_url FROM feedback_qr WHERE id ='.$id);

    $query = "UPDATE feedback_qr SET feedback_url  = '$feedback_url' WHERE id = '$id'";
}



?>

<div class="container">
    <div class="row">
        <div class="col">
            <form id="form" onsubmit="edit_qr(event);">
                <input type="hidden" id="qr_id" value="<?= htmlspecialchars($id) ?>">

                <h2><center>Change Feedback URL</center></h2>

                <div class="form-group">
                    <div class="row">
                        <label for="opac_link">Feedback URL</label>
                        <div class="col">
                            <input id="new_qr" class="form-control" name="new_qr" required value="<?= htmlspecialchars($qr_link) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <button href="javascript:void(0);" class="btn btn-info btn-sm" onclick="edit_qr();">UPDATE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>