<?php
session_name('admin_session');
session_start();
include_once('includes/dbcon.php');

if (!isset($_SESSION['email'])) {
    header("Location: adminlogin.php");
    exit();
}

$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <script type="text/javascript">
        window.history.forward();
    </script> -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /> -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- Load jQuery from a reliable source -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="assets/js/sweetalert.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="assets/js/tinybox.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>

    <title>Admin Dashboard</title>
</head>

<style>
    body {
        padding-top: 0px;

    }

    .tbox {
        position: absolute;
        display: none;
        padding: 14px 17px;
        z-index: 900;
    }

    .tinner {
        padding: 15px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background: #fff url(assets/images/preload.gif) no-repeat 50% 50%;
        border-right: 1px solid #333;
        border-bottom: 1px solid #333;
    }

    .tmask {
        position: absolute;
        display: none;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;
        background: #000;
        z-index: 800
    }

    .tclose {
        position: absolute;
        top: 0px;
        right: 0px;
        width: 30px;
        height: 30px;
        cursor: pointer;
        background: url(assets/images/close.png) no-repeat
    }

    .tclose:hover {
        background-position: 0 -30px
    }

    #error {
        background: #ff6969;
        color: #fff;
        text-shadow: 1px 1px #cf5454;
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 0
    }

    #error .tcontent {
        padding: 10px 14px 11px;
        border: 1px solid #ffb8b8;
        -moz-border-radius: 5px;
        border-radius: 5px
    }

    #success {
        background: #2ea125;
        color: #fff;
        text-shadow: 1px 1px #1b6116;
        border-right: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 10;
        -moz-border-radius: 0;
        border-radius: 0
    }

    #bluemask {
        background: #4195aa
    }

    #frameless {
        padding: 0
    }

    #frameless .tclose {
        left: 6px
    }

    .card-margin {
        margin-bottom: 1px;
    }

    .row {
        margin-left: 1px;
        margin-right: 1px;
    }

    .col-lg-4 {
        padding-left: 1px;
        padding-right: 1px;
    }


    #sidebar-wrapper .active-link {
        background-color: white !important;
        color: #495057 !important;
    }

    #sidebar-wrapper .active-link i {
        color: #495057 !important;
    }

    .active-link {
        background-color: initial;
        color: initial;
    }

    .align-left {
        display: flex;
        justify-content: flex-start;
        gap: 20px;
    }

    .list-group-item {
        text-decoration: none !important;
    }

    #pieChartContainer,
    #barChartContainer {
        min-height: 0;
        /* Reset any previous height issues */
        border: 1px solid #ddd;
        /* Optional, for visual alignment */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadSubContent(url, elementId) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(elementId).innerHTML = "";
                document.getElementById(elementId).innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function loadPage(loc, eid) {
        document.getElementById(eid).innerHTML = "<div align='center'><img src='assets/images/preload.gif' width='35px' /></div>";
        loadSubContent(loc, eid);
    }

    function object(id) {
        return document.getElementById(id);
    }

    function upload_oadb() {
        var yyy = object('yyy').value;
        var oadb = object('oadb').value;
        var url = object('url').value;
        var picInput = document.getElementById('pic');
        var picFile = picInput.files[0];
        var category = document.getElementById('category').value;


        // Debugging to ensure category is captured
        console.log('Category:', category);

        let form = new FormData();
        form.append('yyy', yyy);
        form.append('oadb', oadb);
        form.append('pic', picFile);
        form.append('url', url);
        form.append('category', category); // Append the category to the form data

        Swal.fire({
                title: "Upload OADB",
                text: "Are you sure to upload OADB?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    $.ajax({
                        url: 'admin/pages/e_book.php?get_oadb',
                        type: "POST",
                        data: form,
                        beforeSend: function() {
                            $("#body-overlay").show();
                        },
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#maincontent").html(data);
                            $("#maincontent").css('opacity', '1');
                            $("#body-overlay").hide();

                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });
                            TINY.box.hide();
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed', 'error');
                        }
                    });
                }
            });
    }



    $(document).ready(function() {
        console.log("jQuery Loaded?", typeof jQuery);
        console.log("Dollar Sign ($) Available?", typeof $);
        console.log("jQuery AJAX Type:", typeof $.ajax);

        if (typeof $ === "undefined" || typeof $.ajax !== "function") {
            Swal.fire("Error", "jQuery is not loaded properly!", "error");
            return;
        }

        // Assign function globally
        window.upload_pdf = function() {
            console.log("Inside upload_pdf() function");

            var pdf = document.getElementById('pdf');
            var pdf_callnumber = document.getElementById('pdf_callnumber').value;
            var pdf_name = document.getElementById('pdf_name').value;
            var category = document.getElementById('category').value;
            var pdfFile = pdf.files[0];

            if (!pdfFile) {
                Swal.fire('Error', 'Please select a PDF file to upload.', 'error');
                return;
            }

            var fileExtension = pdfFile.name.split('.').pop().toLowerCase();
            if (fileExtension !== 'pdf') {
                Swal.fire('Error', 'Only PDF files are allowed.', 'error');
                return;
            }

            if (!pdf_name) {
                Swal.fire('Error', 'Please enter a PDF name.', 'error');
                return;
            }

            if (!category) {
                Swal.fire('Error', 'Please select a PDF category.', 'error');
                return;
            }

            let form = new FormData();
            form.append('pdf', pdfFile);
            form.append('pdf_callnumber', pdf_callnumber);
            form.append('pdf_name', pdf_name);
            form.append('category', category);

            Swal.fire({
                title: "Upload PDF?",
                text: "Are you sure you want to upload this PDF?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, upload it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Before first AJAX call:");
                    console.log("jQuery Type:", typeof $);
                    console.log("jQuery AJAX Type:", typeof $.ajax);

                    if (typeof $ === "undefined" || typeof $.ajax !== "function") {
                        Swal.fire("Error", "jQuery is not loaded properly!", "error");
                        return;
                    }

                    $.ajax({
                        url: 'e-resources/check_pdf_duplicate_file.php',
                        type: 'POST',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        async: true, // Ensuring async behavior
                        success: function(response) {
                            console.log("File Check Response:", response);

                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            if (response.exists) {
                                Swal.fire('Error', 'This file has already been uploaded.', 'error');
                            } else {
                                console.log("No duplicate file found. Uploading...");

                                $.ajax({
                                    url: 'e-resources/upload_pdf.php',
                                    type: "POST",
                                    data: form,
                                    beforeSend: function() {
                                        $("#body-overlay").show();
                                    },
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    async: true, // Ensuring async behavior
                                    success: function(data) {
                                        console.log("Upload Response:", data);

                                        $("#body-overlay").hide();

                                        if (data.error) {
                                            Swal.fire('Error', data.error, 'error');
                                            return;
                                        }

                                        if (data.status === 'success') {
                                            Swal.fire({
                                                title: "Success!",
                                                icon: "success",
                                                timer: 2000,
                                                showConfirmButton: false
                                            });

                                            TINY.box.hide();

                                            console.log("After successful upload:");
                                            console.log("jQuery Type:", typeof $);
                                            console.log("jQuery AJAX Type:", typeof $.ajax);

                                            // Reload only the table instead of refreshing the whole page
                                            setTimeout(function() {
                                                console.log("Before table reload AJAX call:");
                                                console.log("jQuery Type:", typeof $);
                                                console.log("jQuery AJAX Type:", typeof $.ajax);

                                                $.ajax({
                                                    url: 'e-resources/add.php', // Your table data source
                                                    type: 'GET',
                                                    async: true, // Ensuring async behavior
                                                    success: function(response) {
                                                        console.log("Table Reload Response:", response);
                                                        $('#pdfTableContainer').html(response); // Update table content
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error("Table Reload Error:", status, error, xhr.responseText);
                                                    }
                                                });
                                            }, 2000);
                                        } else {
                                            Swal.fire('Error', data.message, 'error');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Upload AJAX Error:", status, error, xhr.responseText);
                                        Swal.fire('Error', 'Failed to upload the file.', 'error');
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("File Check AJAX Error:", status, error, xhr.responseText);
                            Swal.fire('Error', 'Failed to check if file exists.', 'error');
                        }
                    });
                }
            });
        };
    });








    function add_admin() {
        var email = object('email').value;
        var password = object('password').value;

        Swal.fire({
                title: 'Add Admin',
                text: 'Add New Admin?',
                icon: 'info',
                showCancelButton: true
            })
            .then((willAdd) => {
                if (willAdd) {
                    x = 'admin/pages/newadmin.php?email=' + email + '&password=' + password;
                    loadPage(x, 'add_admin');
                }
            });
    }

    function delete_ebook(id) {
        Swal.fire({
                title: 'Delete E_Book',
                text: 'Are you sure to delete this E_Book?',
                icon: 'info',
                showCancelButton: true
            })
            .then((willDelete) => {
                if (willDelete) {
                    loadPage('admin/pages/e_book.php?delId=' + id, 'maincontent');
                }
            });
    }

    function delete_pdf(id) {
        Swal.fire({
                title: 'Delete PDF',
                text: 'Are you sure to delete this PDF?',
                icon: 'info',
                showCancelButton: true
            })
            .then((willDelete) => {
                if (willDelete) {
                    loadPage('e-resources/add.php?delId=' + id, 'maincontent');
                }
            });
    }



    function add_admin() {
        var email = object('email').value;
        var password = object('password').value;

        Swal.fire({
                title: 'Add Admin',
                text: 'Add New Admin?',
                icon: 'info',
                button: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    x = 'admin/pages/newadmin.php?email=' + email + '&password=' + password;
                    loadPage(x, 'add_admin');
                }
            });
    }

    function delete_ebook(id) {

        Swal.fire({
                title: 'Delete E_Book',
                text: 'Are you sure to delete this E_Book?',
                icon: 'info',
                button: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    loadPage('admin/pages/e_book.php?delId=' + id, 'maincontent');
                }
            });
    }

    function delete_pdf(id) {

        Swal.fire({
                title: 'Delete PDF',
                text: 'Are you sure to delete this PDF?',
                icon: 'info',
                button: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    loadPage('e-resources/add.php?delId=' + id, 'maincontent');
                }
            });
    }

    function delete_forum(id) {

        Swal.fire({
                title: 'Delete Forum',
                text: 'Are you sure to delete this Title?',
                icon: 'info',
                button: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    loadPage('admin/pages/Forum.php?delId=' + id, 'maincontent');
                }
            });
    }

    function deleteLoginHistory() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete all login history records!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete records
                fetch('pages/delete_login_history.php', {
                        method: 'POST',
                    })
                    .then(response => {
                        if (response.ok && response.status === 204) {
                            // Success case: show success message
                            Swal.fire(
                                'Deleted!',
                                'All login history records have been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page to refresh the table
                            });
                        } else {
                            // Handle non-204 responses (like errors)
                            return response.text().then(text => {
                                throw new Error(text || 'Unexpected response');
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the records: ' + error.message,
                            'error'
                        );
                    });
            }
        });
    }


    function delete_comment(id) {

        Swal.fire({
                title: 'Delete Comment',
                text: 'Are you sure to delete this Comment?',
                icon: 'info',
                button: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    loadPage('admin/pages/Forum.php?CommentId=' + id, 'maincontent');
                }
            });
    }

    function delete_thread(delThread) {

        // var delThread = document.getElementById('threadId').value;
        // console.log(delThread);

        Swal.fire({
                title: 'Delete Thread',
                text: 'Are you sure to delete this Thread?',
                icon: 'info',
                button: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    loadPage('admin/pages/Forum.php?delThread=' + delThread, 'maincontent');
                }
            });
    }


    function edit_oadb() {
        var yyy = object('yyy').value;
        var id = object('id').value;
        var oadb = object('oadb').value;
        var url = object('url').value;
        var category = document.getElementById('category').value; // Get the selected category value
        var picInput = document.getElementById('pic');
        var picFile = picInput.files[0];

        let form = new FormData();
        form.append('yyy', yyy);
        form.append('id', id);
        form.append('oadb', oadb);
        form.append('pic', picFile);
        form.append('url', url);
        form.append('category', category); // Append category to FormData

        Swal.fire({
                title: "Update OADB",
                text: "Are you sure to update OADB?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
                    $.ajax({
                        url: 'admin/pages/e_book.php?edit_oadb',
                        type: "POST",
                        data: form,
                        beforeSend: function() {
                            $("#body-overlay").show();
                        },
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#maincontent").html(data);
                            $("#maincontent").css('opacity', '1');
                            $("#body-overlay").hide();

                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed', 'error');
                        }
                    });
                }
            });
        TINY.box.hide();
    }


    function edit_pdf() {
        var id = document.getElementById('id').value;
        var pdf = document.getElementById('pdf');
        var pdf_name = document.getElementById('pdf_name').value;
        var pdfFile = pdf.files[0];

        if (!pdfFile || !pdf_name) {
            Swal.fire('Error', 'Please provide both PDF file and PDF name', 'error');
            return;
        }

        let form = new FormData();
        form.append('id', id);
        form.append('pdf', pdfFile);
        form.append('pdf_name', pdf_name);

        Swal.fire({
                title: "Edit PDF?",
                text: "Are you sure you want to edit the PDF?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willEdit) => {
                if (willEdit) {
                    $.ajax({
                        url: 'e-resources/add.php?edit_pdf',
                        type: "POST",
                        data: form,
                        beforeSend: function() {
                            $("#body-overlay").show();
                        },
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#maincontent").html(data);
                            $("#maincontent").css('opacity', '1');
                            $("#body-overlay").hide();

                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Failed to edit PDF. Please try again.', 'error');
                        }
                    });
                }
            });
    }


    function edit_opac() {
        event.preventDefault(); // Prevent the default form submission

        // Get values from the form
        var id = document.querySelector('input[name="id"]').value; // Get the ID
        var opac_link = document.getElementById('new_link').value; // Get the OPAC link value

        // Create a FormData object
        let form = new FormData();
        form.append('id', id);
        form.append('new_link', opac_link);

        // SweetAlert confirmation dialog with cancel button
        Swal.fire({
            title: "Update OPAC Link?",
            text: "Are you sure you want to update the OPAC Link?",
            icon: "info",
            showCancelButton: true, // Enable cancel button
            confirmButtonText: "Yes, update it!", // Custom confirm button text
            cancelButtonText: "Cancel", // Custom cancel button text
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) { // If user clicks "Yes, update it!"
                $.ajax({
                    url: 'admin/pages/add_new_opac.php', // Ensure this URL is correct
                    type: "POST",
                    data: form,
                    beforeSend: function() {
                        $("#body-overlay").show(); // Show loading overlay
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#maincontent").html(data);
                        $("#maincontent").css('opacity', '1');
                        $("#body-overlay").hide();

                        // Show success message
                        Swal.fire({
                            title: "Success!",
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        TINY.box.hide();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log the response for debugging
                        Swal.fire('Error', 'Failed: ' + error, 'error');
                    }
                });
            } // If "Cancel" is clicked, nothing happens
        });
    }


    function add_opac() {
        var opac_link = object('opac_link').value;
        let form = new FormData();
        form.append('opac_link', opac_link);

        Swal.fire({
                title: "Add Link?",
                Text: "Are you sure to upload new Link?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
                    $.ajax({
                        url: 'admin/pages/add_new_opac.php?add_opac',
                        type: "POST",
                        data: form,
                        beforeSend: function() {
                            $("#body-overlay").show();
                        },
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#maincontent").html(data);
                            $("#maincontent").css('opacity', '1');
                            $("#body-overlay").hide();

                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed', 'error');
                        }
                    });

                }
            });
    }


    function add_feedback() {
        var feedback_url = document.getElementById('feedback_url').value; // Get feedback URL from input
        let form = new FormData();
        form.append('feedback_url', feedback_url); // Append feedback URL to FormData

        Swal.fire({
                title: "Add Feedback?",
                text: "Are you sure to add this feedback URL?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
                    $.ajax({
                        url: 'admin/pages/Feedback.php',
                        type: "POST",
                        data: form,
                        beforeSend: function() {
                            $("#body-overlay").show();
                        },
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#maincontent").html(data);
                            $("#maincontent").css('opacity', '1');
                            $("#body-overlay").hide();

                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });

                            TINY.box.hide();
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed', 'error');
                        }
                    });

                }
            });
    }


    function edit_qr() {
        event.preventDefault(); // Prevent the default form submission

        // Get values from the form
        var qr_id = document.getElementById('qr_id').value; // Get the ID
        var new_qr = document.getElementById('new_qr').value; // Get the Feedback URL value

        // Create a FormData object
        let form = new FormData();
        form.append('qr_id', qr_id);
        form.append('new_qr', new_qr);

        // SweetAlert confirmation dialog with cancel button
        Swal.fire({
            title: "Update Feedback URL?",
            text: "Are you sure you want to update the Feedback URL?",
            icon: "info",
            showCancelButton: true, // Enable cancel button
            confirmButtonText: "Yes, update it!", // Custom confirm button text
            cancelButtonText: "Cancel", // Custom cancel button text
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) { // If user clicks "Yes, update it!"
                $.ajax({
                    url: 'admin/pages/Feedback.php?new_f', // Ensure this URL is correct
                    type: "POST",
                    data: form,
                    beforeSend: function() {
                        $("#body-overlay").show(); // Show loading overlay
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#maincontent").html(data);
                        $("#maincontent").css('opacity', '1');
                        $("#body-overlay").hide();

                        // Show success message
                        Swal.fire({
                            title: "Success!",
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        TINY.box.hide();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log the response for debugging
                        Swal.fire('Error', 'Failed: ' + error, 'error');
                    }
                });
            } // If "Cancel" is clicked, nothing happens
        });
    }



    function archive_pdf(Aid) {
        let form = new FormData();
        form.append('Aid', Aid);

        Swal.fire({
            title: "Archive?",
            text: "Are you sure you want to archive this e-book?",
            icon: "info",
            showCancelButton: true, // Added Cancel button
            confirmButtonText: "Yes, Archive",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'e-resources/tmpPages/tmpAdd.php',
                    type: "POST",
                    data: form,
                    beforeSend: function() {
                        $("#body-overlay").show();
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tempo").html(data);
                        $("#tempo").css('opacity', '1');
                        $("#body-overlay").hide();

                        Swal.fire({
                            title: "Done!",
                            text: "Archived successfully.",
                            icon: "success", // Corrected checkmark icon
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        TINY.box.hide();
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed', 'error');
                    }
                });
            }
        });
    }

    function unArchived_pdf(Uid) {
        let form = new FormData();
        form.append('Uid', Uid);

        Swal.fire({
            title: "Unarchive?",
            text: "Are you sure you want to unarchive this e-book?",
            icon: "info",
            showCancelButton: true, // Added Cancel button
            confirmButtonText: "Yes, Unarchive",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'e-resources/tmpPages/tmpAdd.php',
                    type: "POST",
                    data: form,
                    beforeSend: function() {
                        $("#body-overlay").show();
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tempo").html(data);
                        $("#tempo").css('opacity', '1');
                        $("#body-overlay").hide();

                        Swal.fire({
                            title: "Done!",
                            text: "Unarchived successfully.",
                            icon: "success", // Corrected checkmark icon
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        TINY.box.hide();
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed', 'error');
                    }
                });
            }
        });
    }

    function OnArchive_ebook(Anid) {
        let form = new FormData();
        form.append('Anid', Anid);

        Swal.fire({
            title: "Archive?",
            text: "Are you sure you want to archive this open access database?",
            icon: "info",
            showCancelButton: true, // Added Cancel button
            confirmButtonText: "Yes, Archive",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'admin/pages/tempPages/tempEbooks.php',
                    type: "POST",
                    data: form,
                    beforeSend: function() {
                        $("#body-overlay").show();
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tempo").html(data);
                        $("#tempo").css('opacity', '1');
                        $("#body-overlay").hide();

                        Swal.fire({
                            title: "Done!",
                            text: "Archived successfully.",
                            icon: "success", // Properly set success icon (checkmark)
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        TINY.box.hide();
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to archive the e-book.",
                            icon: "error",
                        });
                    }
                });
            }
        });
    }

    function InArchived_ebook(Unid) {
        let form = new FormData();
        form.append('Unid', Unid);

        Swal.fire({
            title: "Unarchive?",
            text: "Are you sure you want to unarchive this open access database?",
            icon: "info",
            showCancelButton: true, // Added Cancel button
            confirmButtonText: "Yes, Unarchive",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'admin/pages/tempPages/tempEbooks.php',
                    type: "POST",
                    data: form,
                    beforeSend: function() {
                        $("#body-overlay").show();
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tempo").html(data);
                        $("#tempo").css('opacity', '1');
                        $("#body-overlay").hide();

                        Swal.fire({
                            title: "Done!",
                            text: "Unarchived successfully.",
                            icon: "success", // Properly set success icon (checkmark)
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        TINY.box.hide();
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to unarchive the e-book.",
                            icon: "error",
                        });
                    }
                });
            }
        });
    }

    function edit_account() {

        var accId = document.getElementById('accId').value;
        var email = document.getElementById('email').value;
        var pass = document.getElementById('password').value;

        let form = new FormData();
        form.append('accId', accId);
        form.append('email', email);
        form.append('pass', pass);

        Swal.fire({
                title: "Save Account changes?",
                text: "Are you sure to save account changes?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
                    $.ajax({
                        url: 'admin/admin_side/account.php',
                        type: "POST",
                        data: form,
                        beforeSend: function() {
                            $("#body-overlay").show();
                        },
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#maincontent").html(data);
                            $("#maincontent").css('opacity', '1');
                            $("#body-overlay").hide();

                            Swal.fire("Done!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });

                            TINY.box.hide();
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed', 'error');
                        }
                    });

                }
            });

    }
</script>

<body>
    <div class="d-flex" id="wrapper" style="color:#000;">
        <!-- sidebar to ha -->
        <div style="background-color: #259923;" id="sidebar-wrapper" x`>
            <div class="sidebar-heading text-center py-2 fs-4 fw-bold border-bottom" style="color:#fff">
                <i><img src="assets/images/library.png" width="80px" height="80px" alt=""></i>BELMAppv2.0
            </div>

            <!-- <div class="list-group list-group-flush my-3">

                <a href="javascript:void(0);"
                    onclick="window.location.reload(); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2 fw-bold active" style="color:#fff">
                    <i class="fas fa-gauge me-2" style="color:#fff"></i>Dashboard</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/users.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2" style="color:#fff">
                    <i class="fas fa-user-check me-3" style="color:#fff"></i>Registered Users</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('pages/imported_data.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2" style="color:#fff">
                    <i class="fas fa-users me-3" style="color:#fff"></i>Imported Users</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/e_book.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2" style="color:#fff; font-size: 15px;">
                    <i class="fas fa-book me-3" style="color:#fff"></i>Openaccess Database</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('e-resources/add.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2" style="color:#fff">
                    <i class="fas fa-newspaper me-3" style="color:#fff"></i>E-Resources</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('pages/loghistory.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2" style="color:#fff">
                    <i class="fas fa-clock-rotate-left me-3" style="color:#fff"></i>Log History</a>

                <div class="dropdown mx-3">
                    <button class="btn btn-secondary dropdown-toggle bg-transparent second-text py-2" type="button" id="logHistoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color:#fff; border: none;">
                        <i class="fas fa-clock-rotate-left me-3" style="color:#fff"></i> Log History
                    </button>
                    <ul class="dropdown-menu bg-light" aria-labelledby="logHistoryDropdown">
                        <li><a class="dropdown-item text-dark" href="javascript:void(0);" onclick="loadPage('pages/loghistory.php','maincontent'); setActiveLink(this);">View Log History</a></li>
                        <li><a class="dropdown-item text-dark" href="javascript:void(0);" onclick="loadPage('e-resources/add.php','maincontent'); setActiveLink(this);">Trial</a></li>
                    </ul>
                </div>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/Feedback.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text  py-2" style="color:#fff">
                    <i class="fas fa-comment me-3" style="color:#fff"></i>Feedback Form</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/add_new_opac.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-book me-3" style="color:#fff"></i>OPAC Link</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/Forum.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-comments me-3" style="color:#fff"></i>Forum</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/importData.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-file-import me-3" style="color:#fff"></i>Import Data</a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/exportData.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-download me-3" style="color:#fff"></i>Export Data</a>

            </div> -->

            <div class="list-group list-group-flush my-3">

                <a href="javascript:void(0);"
                    onclick="window.location.reload(); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2 fw-bold active" style="color:#fff">
                    <i class="fas fa-gauge me-2" style="color:#fff"></i>Dashboard
                </a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/users.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-user-check me-3" style="color:#fff"></i>Registered Users
                </a>

                <div class="mx-3">
                    <button class="btn btn-secondary bg-transparent second-text py-2 w-100 text-start" type="button"
                        onclick="toggleAccordion('importedUsersCollapse', 'importedUsersIcon')" style="color:#fff; border: none;">
                        <i class="fas fa-users me-3" style="color:#fff"></i> Imported Users
                        <i class="fa-solid fa-chevron-down float-end" id="importedUsersIcon"></i>
                    </button>
                    <div id="importedUsersCollapse" class="collapse">
                        <ul class="list-group list-group-flush" style="list-style: none; padding-left: 0; margin: 0;">
                            <li>
                                <a class="list-group-item bg-transparent second-text mx-3 py-2" href="javascript:void(0);"
                                    onclick="loadPage('pages/imported_data_user.php','maincontent'); setActiveLink(this);"
                                    style="color:#fff; text-decoration: none;"><i class="fas fa-user-graduate me-2"></i>
                                    Students
                                </a>
                            </li>
                            <li>
                                <a class="list-group-item bg-transparent second-text mx-3 py-2" href="javascript:void(0);"
                                    onclick="loadPage('pages/imported_data_faculty.php','maincontent'); setActiveLink(this);"
                                    style="color:#fff; text-decoration: none;"><i class="fas fa-chalkboard-teacher me-2"></i>
                                    Faculty
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/e_book.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff; font-size: 15px;">
                    <i class="fas fa-book me-3" style="color:#fff"></i>Open Access Database
                </a>

                <a href="javascript:void(0);"
                    onclick="loadPage('e-resources/add.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-newspaper me-3" style="color:#fff"></i>E-Resources
                </a>

                <a href="javascript:void(0);"
                    onclick="loadPage('admin/pages/Forum.php','maincontent'); setActiveLink(this);"
                    class="list-group-item list-group-item-action bg-transparent second-text py-2" style="color:#fff">
                    <i class="fas fa-comments me-3" style="color:#fff"></i>Forum
                </a>

                <div class="mx-3">
                    <button class="btn btn-secondary bg-transparent second-text py-2 w-100 text-start" type="button"
                        onclick="toggleAccordion('importExportCollapse','importExportIcon')" style="color:#fff; border: none;">
                        <i class="fas fa-file-alt me-3" style="color:#fff"></i> Import/Export Data
                        <i class="fa-solid fa-chevron-down float-end" id="importExportIcon"></i>
                    </button>
                    <div id="importExportCollapse" class="collapse">
                        <ul class="list-group list-group-flush" style="list-style: none; padding-left: 0; margin: 0;">
                            <li>
                                <a class="list-group-item bg-transparent second-text mx-3 py-2" href="javascript:void(0);"
                                    onclick="loadPage('admin/pages/importData.php','maincontent'); setActiveLink(this);"
                                    style="color:#fff; text-decoration: none;">
                                    <i class="fas fa-file-import me-3" style="color:#fff"></i> Import Data
                                </a>
                            </li>
                            <li>
                                <a class="list-group-item bg-transparent second-text mx-3 py-2" href="javascript:void(0);"
                                    onclick="loadPage('admin/pages/exportData.php','maincontent'); setActiveLink(this);"
                                    style="color:#fff; text-decoration: none;">
                                    <i class="fas fa-download me-3" style="color:#fff"></i> Export Data
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class='mx-3'>
                    <button class='btn btn-secondary bg-transparent second-text py-2 w-100 text-start' type='button'
                        onclick="toggleAccordion('opacFeedbackCollapse', 'opacFeedbackIcon')" style='color:#fff; border: none;'>
                        <i class='fas fa-layer-group me-3' style='color:#fff'></i> Editable Links
                        <i class='fa-solid fa-chevron-down float-end' id='opacFeedbackIcon'></i>
                    </button>
                    <div id='opacFeedbackCollapse' class='collapse'>
                        <ul class='list-group list-group-flush' style='list-style: none; padding-left: 0; margin: 0;'>
                            <li>
                                <a class='list-group-item bg-transparent second-text mx-3 py-2' href='javascript:void(0);'
                                    onclick="loadPage('admin/pages/Feedback.php', 'maincontent'); setActiveLink(this);"
                                    style='color:#fff; text-decoration: none;'>
                                    <i class='fas fa-comment me-3' style='color:#fff'></i> Feedback Form
                                </a>
                            </li>
                            <li>
                                <a class='list-group-item bg-transparent second-text mx-3 py-2' href='javascript:void(0);'
                                    onclick="loadPage('admin/pages/add_new_opac.php', 'maincontent'); setActiveLink(this);"
                                    style='color:#fff; text-decoration: none;'>
                                    <i class='fas fa-book me-3' style='color:#fff'></i> OPAC Link
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mx-3">
                    <button class="btn btn-secondary bg-transparent second-text py-2 w-100 text-start" type="button"
                        onclick="toggleAccordion('logHistoryCollapse','logHistoryIcon')" style="color:#fff; border: none;">
                        <i class="fas fa-clock-rotate-left me-3" style="color:#fff"></i> Log History
                        <i class="fa-solid fa-chevron-down float-end" id="logHistoryIcon"></i>
                    </button>
                    <div id="logHistoryCollapse" class="collapse">
                        <ul class="list-group list-group-flush" style="list-style: none; padding-left: 0; margin: 0;">
                            <li>
                                <a class="list-group-item bg-transparent second-text mx-3 py-2" href="javascript:void(0);" onclick="loadPage('pages/most_frequent.php','maincontent'); setActiveLink(this);" style="color:#fff; text-decoration: none;">
                                    <i class="fas fa-chart-line me-2"></i>Most Frequent</a>
                            </li>
                            <li>
                                <a class="list-group-item bg-transparent second-text mx-3 py-2" href="javascript:void(0);" onclick="loadPage('pages/loghistory.php','maincontent'); setActiveLink(this);" style="color:#fff; text-decoration: none;">
                                    <i class="fas fa-user-clock me-2"></i>User Login</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- JavaScript Function for Toggle -->
            <!-- <script>
                function toggleAccordion(id) {
                    var element = document.getElementById(id);
                    if (element.classList.contains('show')) {
                        element.classList.remove('show'); 
                    } else {
                        element.classList.add('show'); 
                    }
                }

                function toggleAccordion(elementId) {
                    var collapseElement = document.getElementById(elementId);
                    var icon = document.getElementById('logHistoryIcon');

                    if (collapseElement.classList.contains('show')) {
                        collapseElement.classList.remove('show');
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    } else {
                        collapseElement.classList.add('show');
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }

                function toggleAccordion(elementId) {
                    var collapseElement = document.getElementById(elementId);
                    var icon = document.getElementById('importedUsersIcon');

                    if (collapseElement.classList.contains('show')) {                 
                        collapseElement.classList.remove('show');
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    } else {                       
                        collapseElement.classList.add('show');
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }
            </script> -->

            <script>
                function toggleAccordion(elementId, iconId) {
                    var collapseElement = document.getElementById(elementId);
                    var icon = document.getElementById(iconId);

                    // Close all collapses except the clicked one
                    document.querySelectorAll('.collapse').forEach(function(el) {
                        if (el.id !== elementId && el.classList.contains('show')) {
                            el.classList.remove('show');
                        }
                    });

                    // Update all icons to down arrow, except the clicked one
                    document.querySelectorAll('.fa-chevron-up, .fa-chevron-down').forEach(function(el) {
                        if (el.id !== iconId) {
                            el.classList.remove('fa-chevron-up');
                            el.classList.add('fa-chevron-down');
                        }
                    });

                    // Toggle the clicked accordion
                    if (collapseElement.classList.contains('show')) {
                        collapseElement.classList.remove('show');
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    } else {
                        collapseElement.classList.add('show');
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }

                // Close all collapses when any other sidebar link is clicked
                document.querySelectorAll('.list-group-item-action').forEach(link => {
                    link.addEventListener('click', function() {
                        document.querySelectorAll('.collapse').forEach(collapse => {
                            collapse.classList.remove('show');
                        });
                        document.querySelectorAll('.fa-chevron-up').forEach(icon => {
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        });
                    });
                });
            </script>


        </div>

        <!--sa page content to -->
            <div id="page-content-wrapper" style="background-color:white">
                <nav class="navbar navbar-expand-lg navbar-light bg-darkgreen py-4 px-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle" style="color:#000"></i>
                        <h2 class="fs-2 m-0">Dashboard</h2>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i><?php echo $email; ?>
                                </a>
                                <!-- <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadPage('admin/admin_side/table.php','maincontent');">List of Admin</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadPage('admin/admin_side/account.php','maincontent');">Change password</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="TINY.box.show({url:'admin/pages/newadmin.php',width:400,height:400})">Add admin Account</a></li>
                                <li><a class="dropdown-item" href="session/logout.php">Logout</a></li>
                            </ul> -->

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="loadPage('admin/admin_side/table.php','maincontent');">
                                            <i class="fas fa-list"></i> List of Admin
                                        </a>
                                    </li>
                                    <!-- <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="loadPage('admin/admin_side/account.php','maincontent');">
                                        <i class="fas fa-key"></i> Change password
                                    </a>
                                </li> -->
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="TINY.box.show({url:'admin/pages/newadmin.php',width:400,height:400})">
                                            <i class="fas fa-user-plus"></i> Add Admin Account
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="session/logout.php">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </li>
                                </ul>

                            </li>
                        </ul>
                    </div>
                </nav>
                <?php
                $q = 'SELECT COUNT(*) FROM users';
                $rs = mysqli_query($conn, $q);
                $rw = mysqli_fetch_array($rs);
                $count_user = $rw[0];
                ?>
                <?php
                $q = 'SELECT COUNT(*) FROM pdf_file WHERE is_archived = 0';
                $rs = mysqli_query($conn, $q);
                $rw = mysqli_fetch_array($rs);
                $count_eresources = $rw[0];
                ?>
                <?php
                // $q = 'SELECT COUNT(*) FROM open_access_db';
                $q = 'SELECT COUNT(*) FROM open_access_db WHERE is_archived = 0';
                $rs = mysqli_query($conn, $q);
                $rw = mysqli_fetch_array($rs);
                $count_open_access_db = $rw[0];
                ?>
                <?php
                $q = 'SELECT COUNT(*) FROM feedback_qr';
                $rs = mysqli_query($conn, $q);
                $rw = mysqli_fetch_array($rs);
                $count_feedback_qr = $rw[0];
                ?>

                <div class="container" id="maincontent" style="background-color:white">
                    <div class="row">

                        <div class="col-lg-4 mb-2">
                            <div class="card card-margin py-2">
                                <div class="card-header no-border">
                                    <i class="fas fa-user-alt" style="font-size:20px; color: #31a531;  margin-right: 20px;"></i>
                                    <h5 class="card-title " style="margin-right: 1rem;">Most Frequent User:</h5>
                                    <h6 class="fw-bold" style="font-size: 20px; color:#31a531;"><?php echo getMostActiveUser($conn); ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-2">
                            <div class="card card-margin py-2">
                                <div class="card-header no-border">
                                    <i class="fa fa-book" style="font-size:26px; color: #31a531;  margin-right: 25px;"></i>
                                    <h5 class="card-title" style="margin-right: 1rem;">E-Resources:</h5>
                                    <h3 class="fs-2" style="font-size: 20px; color:#31a531;"><?php echo $count_eresources; ?></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-2">
                            <div class="card card-margin py-2">
                                <div class="card-header no-border">
                                    <i class="fas fa-book-open" style="font-size:25px; color: #31a531;  margin-right: 25px;"></i>
                                    <h5 class="card-title" style="margin-right: 1rem;">Open Access Databases:</h5>
                                    <h3 class="fs-2" style="font-size: 1.5rem; color:#31a531;"><?php echo $count_open_access_db; ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-lg-4 mb-2">
                        <div class="card card-margin py-2">
                            <div class="card-header no-border">
                                <i class="fa fa-upload" style="font-size:26px; color: #31a531;  margin-right: 25px;"></i>
                                <h5 class="card-title" style="margin-right: 2rem;">Uploaded Feedback Form:</h5>
                                <h3 class="fs-2" style="font-size: 1.5rem; color:#31a531;"><?php echo $count_feedback_qr; ?></h3>
                            </div>
                        </div>
                    </div> -->

                        <div class="col-lg-4 mb-2">
                            <div class="card card-margin py-2">
                                <div class="card-header no-border">
                                    <i class="fas fa-users" style="font-size:26px; color: #31a531; margin-right: 25px;"></i>
                                    <h5 class="card-title" style="margin-right: 2rem;">Registered Users:</h5>
                                    <h3 class="fs-2" style="font-size: 20px; color:#31a531;"><?php echo $count_user; ?></h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-2">
                            <div class="card card-margin py-2">
                                <div class="card-header no-border">
                                    <i class="fa fa-male" style="font-size:26px; color: #31a531;  margin-right: 25px;"></i>
                                    <h5 class="card-title" style="margin-right: 1rem;">Male Users:</h5>
                                    <h3 class="fs-2" style="font-size: 1.5rem; color:#31a531;">
                                        <?php
                                        echo get("
                                            SELECT COUNT(*) AS total_males 
                                            FROM (
                                                SELECT a.student_id AS person_id, a.sex 
                                                FROM students a 
                                                INNER JOIN users b ON a.student_id = b.id 
                                                WHERE a.sex = 'M' AND b.email IS NOT NULL
                                                
                                                UNION ALL
                                                
                                                SELECT c.instructor_id AS person_id, c.sex 
                                                FROM instructors c 
                                                INNER JOIN users d ON c.instructor_id = d.id 
                                                WHERE c.sex = 'M' AND d.email IS NOT NULL
                                            ) AS combined;
                                        ");
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row justify-content-start">
                        <div class="col-md-5">
                            <div class="p-3 bg-white shadow rounded" id="barChartContainer" style="height: 350px;">
                                <h3 class="fs-5 text-center">Institute</h3>
                                <canvas id="courseBarChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="p-3 bg-white shadow rounded" id="lineChartContainer" style="height: 350px;">
                                <h3 class="fs-5 text-center">Top Viewed E-Books</h3>
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card p-2 bg-white shadow rounded" id="mostFrequentUsersContainer" style="height: 350px; overflow-y: auto; font-size: 13px;">
                                <h3 class="text-center" style="font-size: 17px; font-weight: bold;">Most Frequent Users</h3>
                                <table class="table table-bordered table-sm text-center" style="border: 1px solid darkgrey;">

                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;" class="text-uppercase">Rank</th>
                                            <th style="font-size: 12px;" class="text-uppercase">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = "SELECT a.username, COUNT(b.user_id) AS login_count FROM users a
                              LEFT JOIN login_history b ON a.id = b.user_id
                              GROUP BY a.username
                              ORDER BY login_count DESC
                              LIMIT 5";
                                        $result = mysqli_query($conn, $q);
                                        $n = 1;
                                        while ($rw = mysqli_fetch_array($result)) {
                                            echo '<tr>';
                                            echo '<td style="font-size: 26px;">' . $n++ . '.' . '</td>';
                                            echo '<td style="font-size: 13px;" class="text-uppercase">' . $rw['username'] . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    // Fetch course distribution data
                    const courseCounts = <?php
                                            $query = "SELECT institute, COUNT(*) as count FROM students GROUP BY institute";
                                            $result = $conn->query($query);
                                            $data = ['courses' => [], 'counts' => []];
                                            while ($row = $result->fetch_assoc()) {
                                                $data['courses'][] = $row['institute'];
                                                $data['counts'][] = $row['count'];
                                            }
                                            echo json_encode($data);
                                            ?>;

                    // Format labels into multiline text
                    const formattedCourses = courseCounts.courses.map(course => course.split(' '));

                    const courseData = {
                        labels: formattedCourses,
                        datasets: [{
                            label: 'Number of Students',
                            data: courseCounts.counts,
                            backgroundColor: 'rgba(0, 123, 255, 0.8)', // Compact blue color
                            borderWidth: 1
                        }]
                    };

                    const barConfig = {
                        type: 'bar',
                        data: courseData,
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: ''
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Institute'
                                    },
                                    ticks: {
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Students'
                                }
                            },
                            barThickness: 40, // Adjusts the bar thickness
                            maxBarThickness: 50 // Ensures bars don't get too thick
                        }
                    };

                    new Chart(document.getElementById('courseBarChart'), barConfig);

                    // Fetch book views data
                    const bookData = <?php echo json_encode(getbooks()); ?>;
                    const bookLabels = bookData.names.map(name => name.length > 20 ? name.substring(0, 20) + '...' : name);
                    const bookViews = bookData.views;

                    const ctx = document.getElementById('lineChart').getContext('2d');

                    const lineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: bookLabels,
                            datasets: [{
                                label: 'Views',
                                data: bookViews,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: ''
                                    },
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 45,
                                        minRotation: 45
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Views'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };
    </script>
    <script>
        function setActiveSidebarLink() {
            const links = document.querySelectorAll('.list-group-item'); // Get all sidebar links
            const currentPage = window.location.pathname; // Get current page URL

            // Loop through each link and add the active class to the matching one
            links.forEach(link => {
                // If the link's href matches the current page URL, add 'active' and 'bg-lightgreen' classes
                if (link.href.includes(currentPage)) {
                    link.classList.add('active', 'bg-lightgreen');
                } else {
                    // Otherwise, remove these classes
                    link.classList.remove('active', 'bg-lightgreen');
                }
            });
        }
    </script>
    <script>
        function setActiveLink(element) {
            // Remove active class from all links
            const links = document.querySelectorAll('#sidebar-wrapper .list-group-item');
            links.forEach(link => link.classList.remove('active-link'));

            // Add active class to the clicked link
            element.classList.add('active-link');
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pieChartContainer = document.getElementById("pieChartContainer");
            const barChartContainer = document.getElementById("barChartContainer");

            // Get heights
            const pieChartHeight = pieChartContainer.offsetHeight;
            const barChartHeight = barChartContainer.offsetHeight;

            // Determine the max height
            const maxHeight = Math.max(pieChartHeight, barChartHeight);

            // Apply the max height to both containers
            pieChartContainer.style.height = maxHeight + "px";
            barChartContainer.style.height = maxHeight + "px";
        });


        function testFileCheck() {
            let formData = new FormData();
            formData.append('pdf', new Blob(), 'test.pdf'); // Simulate a file upload

            $.ajax({
                url: 'e-resources/check_pdf_duplicate_file.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log("Server Response:", response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, xhr.responseText);
                }
            });
        }

        // Call this function to test it
        testFileCheck();
    </script>


    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>