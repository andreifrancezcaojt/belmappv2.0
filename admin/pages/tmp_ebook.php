<?php
include_once('../../includes/dbcon.php');

?>

<style>
    table.table td a{
        color:#fff;
    }
</style>

<div class="row p-5">
    <?php

    $q = 'SELECT * FROM tbl_ebook';
    $rs = mysqli_query($conn, $q);

    while ($rw = mysqli_fetch_array($rs)) {
        echo '<div class="col-3 mb-3">
                <div class="card" style="width: 18rem;">
                
                    <img src="uploads/' . $rw['image'] . '" height="240px" class="card-img-top" alt="Book Image">
                    <div class="card-body">
                        <p class="card-text">Url: ' . $rw['url'] . '</p>
                    </div>
                </div>
            </div>';
    }
    ?>
</div>

