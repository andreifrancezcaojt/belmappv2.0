<?php
include('../../includes/dbcon.php');

// Initialize the OPAC link variable
$opac_link = ''; // Default to an empty string

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($id === null) {
        die('ID not specified');
    }

    // Fetch the OPAC link from the database
    $opac_link = get("SELECT opac_link FROM opac WHERE id = '$id'");

    if ($opac_link === null) {
        $opac_link = ''; // Default to empty if not found
        error_log("No OPAC link found for ID: $id"); // Log for debugging
    }

    // Output the form here, with $opac_link correctly set

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['opac_link'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $opac_link = mysqli_real_escape_string($conn, $_POST['opac_link']);

        // Update query
        $query = "UPDATE opac SET opac_link = '$opac_link' WHERE id = '$id'";

        if (mysqli_query($conn, $query)) {
            echo "Update successful"; // Respond with a success message
        } else {
            echo "Error updating record: " . mysqli_error($conn); // Display error message
        }
    } else {
        echo "ID or OPAC link not specified"; // Handle missing variables gracefully
    }
} else {
    echo "Invalid request"; // Handle invalid request method
}

?>


<div class="container">
    <div class="row">
        <div class="col">
            <form id="form" onsubmit="edit_opac(event);">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                <h2><center>Change OPAC Link</center></h2>

                <div class="form-group">
                    <div class="row">
                        <label for="opac_link">Change OPAC Link</label>
                        <div class="col">
                            <input id="new_link" class="form-control" name="new_link" required value="<?= htmlspecialchars($opac_link) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <button href="javascript:void(0);" class="btn btn-info btn-sm" onclick="edit_opac();">UPDATE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
