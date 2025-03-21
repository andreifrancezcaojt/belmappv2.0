<?php
include('../../includes/dbcon.php');

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $qr_link = get('SELECT feedback_url FROM feedback_qr WHERE id ='.$id);

    $query = "UPDATE feedback_qr SET feedback_url  = '$feedback_url' WHERE id = '$id'";
}



?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <form id="form" onsubmit="edit_qr(event);">
                <input type="hidden" id="qr_id" value="<?= htmlspecialchars($id) ?>">

                <h3><center>Change Feedback URL</center></h3>

                <div class="form-group mt-4">
                    <div class="row">
                        <label for="opac_link" class="fw-bold">Add a new url:</label>
                        <div class="col">
                            <input id="new_qr" class="form-control" name="new_qr" required value="<?= htmlspecialchars($qr_link) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="row">
                        <div class="col">
                            <button href="javascript:void(0);" class="btn btn-success btn-sm" onclick="edit_qr();">UPDATE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>