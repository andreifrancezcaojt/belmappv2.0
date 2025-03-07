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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- <script src="assets/js/sweetalert.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="assets/js/tinybox.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


    #pieChartContainer,
    #barChartContainer {
        min-height: 0;
        /* Reset any previous height issues */
        border: 1px solid #ddd;
        /* Optional, for visual alignment */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        document.getElementById(eid).innerHTML = "<div align='center'><img src='assets/image/loader.gif' width='35px' /></div>";
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

    function upload_pdf() {
        var pdf = document.getElementById('pdf');
        var pdf_callnumber = document.getElementById('pdf_callnumber').value;
        var pdf_name = document.getElementById('pdf_name').value;
        var category = document.getElementById('category').value; // Get the category value
        var pdfFile = pdf.files[0];

        // Check if file is selected and valid PDF type
        if (!pdfFile) {
            Swal.fire('Error', 'Please select a PDF file to upload.', 'error');
            return;
        }

        var fileExtension = pdfFile.name.split('.').pop().toLowerCase();
        if (fileExtension !== 'pdf') {
            Swal.fire('Error', 'Only PDF files are allowed.', 'error');
            return;
        }

        // Check if PDF name and category are provided
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
        form.append('category', category); // Add category to FormData

        // Confirm upload with SweetAlert2
        Swal.fire({
            title: "Upload PDF?",
            text: "Are you sure you want to upload this PDF?",
            icon: "info",
            showCancelButton: true, // Corrected
            confirmButtonText: "Yes, upload it!", // Corrected
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) { // Corrected

                // Check if a PDF with the same name already exists in the database
                $.ajax({
                    url: 'e-resources/check_pdf_duplicate_name.php',
                    type: 'POST',
                    data: {
                        pdf_name: pdf_name
                    },
                    success: function(response) {
                        if (response.exists) {
                            Swal.fire('Error', 'A PDF with this name already exists.', 'error');
                        } else {
                            // Check if the same file already exists on the server
                            $.ajax({
                                url: 'e-resources/check_pdf_duplicate_file.php',
                                type: 'POST',
                                data: form,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.exists) {
                                        Swal.fire('Error', 'This file has already been uploaded.', 'error');
                                    } else {
                                        // If no duplicates, upload the file
                                        $.ajax({
                                            url: 'e-resources/upload_pdf.php', // Ensure correct path to PHP handler
                                            type: "POST",
                                            data: form,
                                            beforeSend: function() {
                                                $("#body-overlay").show();
                                            },
                                            contentType: false,
                                            processData: false,
                                            success: function(data) {
                                                let jsonResponse = JSON.parse(data); // Parse the JSON response

                                                // Check the response status
                                                if (jsonResponse.status === 'success') {

                                                    $("#body-overlay").hide(); // Hide overlay
                                                    Swal.fire({
                                                        title: "Success!",
                                                        icon: "success",
                                                        timer: 2000,
                                                        showConfirmButton: false // Corrected
                                                    });

                                                    TINY.box.hide();

                                                    // Reload the page after success
                                                    setTimeout(function() {
                                                        location.href = "e-resources/tmpPages/tmpAdd"; // Add hash to the URL before reload
                                                        location.reload(); // Reload the page
                                                    }, 2000);


                                                } else {
                                                    Swal.fire('Error', jsonResponse.message, 'error');
                                                }
                                            },
                                            error: function() {
                                                Swal.fire('Error', 'Failed to upload the file.', 'error');
                                            }
                                        });
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error', 'Failed to check if file exists.', 'error');
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to check if file name exists.', 'error');
                    }
                });
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


    // function add_book(){
    //     var url = object('url').value;

    //     swal({
    //         title: 'Add Book',
    //         text: 'Add book url?',
    //         icon: 'info',
    //         button: true,
    //         dangerMode: true,
    //     })
    //     .then((willAdd) => {
    //         if(willAdd){
    //             x = 'admin/pages/new_ebook.php?url='+url;
    //             loadPage(x, 'newAdmin');
    //         }
    //     });
    // }

    // function uploadFormData() {
    //     var formData = new FormData(document.getElementById('uploadForm'));

    //     $.ajax({
    //         url: 'admin/pages/tmp_ebook.php', // URL to your server-side script
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             Handle successful response from server
    //             console.log(response);
    //         },
    //         error: function(xhr, status, error) {
    //             Handle error
    //             console.error(xhr.responseText);
    //         }
    //     });

    // }

    //     function upload_book() {
    //     var url = $('#url').val(); // Corrected selector to get value using jQuery
    //     var picInput = document.getElementById('bookImage');
    //     var picFile = picInput.files[0];

    //     // Check if both URL and image are provided
    //     if (!url || !picFile) {
    //         swal("Error!", "Please provide both URL and image.", "error");
    //         return;
    //     }

    //     var formData = new FormData();
    //     formData.append('url', url);
    //     formData.append('bookImage', picFile);

    //     swal({
    //         title: "Upload This Book?",
    //         text: "Are you sure to upload this picture?",
    //         icon: "info",
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //     .then((willUpload) => {
    //         if (willUpload) {
    //             $.ajax({
    //                 url: 'admin/pages/e_book.php',
    //                 type: "POST",
    //                 data: formData,
    //                 beforeSend: function() {
    //                     $("#body-overlay").show();
    //                 },
    //                 contentType: false,
    //                 processData: false,
    //                 success: function(data) {
    //                     var response = JSON.parse(data);
    //                     $("#maincontent").html(response.html);
    //                     $("#maincontent").css('opacity', '1');
    //                     $("#body-overlay").hide();

    //                     swal("Success!", {
    //                         icon: 'success',
    //                         buttons: false,
    //                         timer: 2000,
    //                     });
    //                 },
    //                 error: function() {
    //                     swal('Error', 'Failed', 'error', 500000);
    //                 }
    //             });
    //         }
    //     });
    // }

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

        // SweetAlert confirmation dialog
        Swal.fire({
                title: "Update OPAC Link?",
                text: "Are you sure you want to update the OPAC Link?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
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
                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });

                            TINY.box.hide();

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log the response for debugging
                            Swal.fire('Error', 'Failed: ' + error, 'error');
                        }
                    });
                }
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
        var new_qr = document.getElementById('new_qr').value; // Get the OPAC link value

        //console.log(qr_id + new_feedback);

        // Create a FormData object
        let form = new FormData();
        form.append('qr_id', qr_id);
        form.append('new_qr', new_qr);

        // SweetAlert confirmation dialog
        Swal.fire({
                title: "Update Feedback URL?",
                text: "Are you sure you want to update the Feedback URL?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willAdd) => {
                if (willAdd) {
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
                            Swal.fire("Success!", {
                                icon: 'success',
                                buttons: false,
                                timer: 2000,
                            });

                            TINY.box.hide();

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log the response for debugging
                            Swal.fire('Error', 'Failed: ' + error, 'error');
                        }
                    });
                }
            });
    }



    function archive_pdf(Aid) {

        let form = new FormData();
        form.append('Aid', Aid);

        Swal.fire({
                title: "Archive?",
                text: "Are you sure to archive this e-book?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
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

    function unArchived_pdf(Uid) {

        let form = new FormData();
        form.append('Uid', Uid);

        Swal.fire({
                title: "Unarchive?",
                text: "Are you sure to unarchive this e-book?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
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

    // function OnArchive_ebook(id){

    //     // Swal.fire.fire({
    //     //     title: 'Hello!',
    //     //     text: 'This is a simple SweetAlert2 alert.',
    //     //     icon: 'success',
    //     //     confirmButtonText: 'OK'
    //     // });



    // }



    function OnArchive_ebook(Anid) {

        let form = new FormData();
        form.append('Anid', Anid);

        // Swal.fire({
        //         title: "Archive?",
        //         text: "Are you sure to archive this e-books?",
        //         icon: "info",
        //         buttons: true,
        //         dangerMode: true,
        //     })
        Swal.fire({
                // title: 'Hello!',
                // text: 'This is a simple SweetAlert2 alert.',
                // icon: 'success',
                // confirmButtonText: 'OK'
                title: "Archive?",
                text: "Are you sure to archive this open access database?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
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


    function InArchived_ebook(Unid) {

        let form = new FormData();
        form.append('Unid', Unid);

        Swal.fire({
                title: "Unarchive?",
                text: "Are you sure to unarchive this open access database?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })

            .then((willAdd) => {
                if (willAdd) {
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

            <div class="list-group list-group-flush my-3">

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

            </div>
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
                                <i class="fas fa-user-alt" style="font-size:26px; color: #31a531;  margin-right: 20px;"></i>
                                <h5 class="card-title " style="margin-right: 1rem;">Most Frequent User:</h5>
                                <h6 class="text-success fw-bold" style="font-size: 1.3rem;"><?php echo getMostActiveUser($conn); ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <div class="card card-margin py-2">
                            <div class="card-header no-border">
                                <i class="fas fa-users" style="font-size:26px; color: #31a531; margin-right: 25px;"></i>
                                <h5 class="card-title" style="margin-right: 2rem;">Total No. Of Users:</h5>
                                <h3 class="fs-2 text-success" style="font-size: 1.5rem;"><?php echo $count_user; ?></h>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <div class="card card-margin py-2">
                            <div class="card-header no-border">
                                <i class="fa fa-book" style="font-size:26px; color: #31a531;  margin-right: 25px;"></i>
                                <h5 class="card-title" style="margin-right: 1rem;">Total No. of E-Resources:</h5>
                                <h3 class="fs-2 text-success" style="font-size: 1.5rem;"><?php echo $count_eresources; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <div class="card card-margin py-2">
                            <div class="card-header no-border">
                                <i class="fas fa-book-open" style="font-size:26px; color: #31a531;  margin-right: 25px;"></i>
                                <h5 class="card-title" style="margin-right: 1rem; font-size:16px;">Total No. of Open Access Databases:</h5>
                                <h3 class="fs-2 text-success" style="font-size: 1.5rem;"><?php echo $count_open_access_db; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <div class="card card-margin py-2">
                            <div class="card-header no-border">
                                <i class="fa fa-upload" style="font-size:26px; color: #31a531;  margin-right: 25px;"></i>
                                <h5 class="card-title" style="margin-right: 2rem;">Uploaded Feedback Form:</h5>
                                <h3 class="fs-2 text-success" style="font-size: 1.5rem;"><?php echo $count_feedback_qr; ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <div class="card card-margin py-2">
                            <div class="card-header no-border">
                                <i class="fa fa-male" style="font-size:20px; color: #31a531;  margin-right: 20px; margin-bottom: 4px;"></i>
                                <h6 class="card-title" style="font-size:14px;">
                                    <b>Male:<span style="margin-left: 45px; color:green; font-size:25px;"><?php echo get("SELECT COUNT(a.student_id), a.sex, b.id FROM students a, users b WHERE a.sex = 'M' AND a.student_id = b.id"); ?></span></b>
                                </h6>
                                <h6 class="card-title" style="font-size:14px;">
                                    <b style="margin-left: 85px;"><i class="fa fa-female" style="color: #31a531; margin-right: 20px; font-size:20px;"></i>Female:<span style="margin-left: 45px; color:green; font-size:25px;"><?php echo get("SELECT COUNT(a.student_id), a.sex, b.id FROM students a, users b WHERE a.sex = 'F' AND a.student_id = b.id"); ?></span></b>
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row justify-content-start">
                            <div class="col-md-4">
                                <div class="p-3 bg-white shadow rounded" id="pieChartContainer">
                                    <h3 class="fs-4 text-center">Course Distribution</h3>
                                    <canvas id="coursePieChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-white shadow rounded" id="barChartContainer">
                                    <div class="chart-container p-3">
                                        <h2 class="text-center" style="font-size: 24px;">Top Viewed E-Resources</h2>
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-3 bg-white shadow rounded" id="barChartContainer">
                                    <table class="table table-sm" style="height: 330px;">
                                        <h1 style="text-align:center; font-size: 25px;">Most Frequent Users</h1>
                                        <thead>
                                            <tr>
                                                <th>Rank</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $q = "SELECT a.username, COUNT(b.user_id) AS login_count
                                FROM users a
                                LEFT JOIN login_history b ON a.id = b.user_id
                                GROUP BY a.username
                                ORDER BY login_count DESC
                                LIMIT 4";
                                            $result = mysqli_query($conn, $q);
                                            $n = 1;
                                            while ($rw = mysqli_fetch_array($result)) {
                                                echo '<tr>';
                                                echo '<td>' . $n++ . '.' . '</td>';
                                                echo '<td>' . $rw['username'] . '</td>';
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
                        // PHP to fetch course counts
                        const courseCounts = <?php
                                                // Fetch course counts from the database
                                                $query = "SELECT course, COUNT(*) as count FROM students GROUP BY course";
                                                $result = $conn->query($query);
                                                $courses = [];
                                                $counts = [];

                                                while ($row = $result->fetch_assoc()) {
                                                    $courses[] = $row['course'];
                                                    $counts[] = $row['count'];
                                                }

                                                // Convert PHP arrays to JSON for JavaScript
                                                echo json_encode(['courses' => $courses, 'counts' => $counts]);
                                                ?>;

                        // Prepare data for the pie chart
                        const courseData = {
                            labels: courseCounts.courses,
                            datasets: [{
                                label: 'Courses',
                                data: courseCounts.counts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.5)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.3)',
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(153, 102, 255, 0.9)',
                                    'rgba(255, 159, 64, 0.7)'
                                ],
                                borderColor: 'rgba(255, 255, 255, 1)',
                                borderWidth: 1
                            }]
                        };

                        const pieConfig = {
                            type: 'pie',
                            data: courseData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Distribution of Courses'
                                    }
                                },
                                // Adding options to make sure the totals are visible on the pie chart
                                animations: {
                                    tension: {
                                        duration: 1000,
                                        easing: 'easeInOutQuad',
                                        from: 1,
                                        to: 0,
                                        loop: true
                                    }
                                }
                            },
                            // Adding a callback to show data labels directly on the pie chart slices
                            plugins: [{
                                afterDatasetsDraw: function(chart) {
                                    const ctx = chart.ctx;
                                    chart.data.datasets.forEach((dataset, i) => {
                                        const meta = chart.getDatasetMeta(i);
                                        if (!meta.hidden) {
                                            meta.data.forEach((element, index) => {
                                                const fontSize = 14;
                                                const fontStyle = 'bold';
                                                const fontFamily = 'Arial';
                                                const fontColor = '#black'; // White color for visibility
                                                ctx.fillStyle = fontColor;

                                                const value = dataset.data[index];
                                                const text = value;

                                                // Calculate text positioning
                                                const position = element.tooltipPosition();
                                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
                                                ctx.fillText(text, position.x - 10, position.y);
                                            });
                                        }
                                    });
                                }
                            }]
                        };

                        const coursePieChart = new Chart(
                            document.getElementById('coursePieChart'),
                            pieConfig
                        );


                        // Fetch the book data
                        const bookData = <?php echo json_encode(getbooks()); ?>;
                        const bookLabels = bookData.names; // Extract book names
                        const bookViews = bookData.views; // Extract views for each book

                        const ctx = document.getElementById('barChart').getContext('2d');

                        // Bar chart
                        const barChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: bookLabels,
                                datasets: [{
                                    label: 'Views',
                                    data: bookViews, // Use the views from the database
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                // Adding options to show the totals directly on the bars
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    }
                                }
                            },
                            // Adding a callback to show data labels directly on the bars
                            plugins: [{
                                afterDatasetsDraw: function(chart) {
                                    const ctx = chart.ctx;
                                    chart.data.datasets.forEach((dataset, i) => {
                                        const meta = chart.getDatasetMeta(i);
                                        if (!meta.hidden) {
                                            meta.data.forEach((element, index) => {
                                                const fontSize = 14;
                                                const fontStyle = 'bold';
                                                const fontFamily = 'Arial';
                                                const fontColor = '#000000'; // Black color for visibility
                                                ctx.fillStyle = fontColor;

                                                const value = dataset.data[index];
                                                const text = value;

                                                // Calculate text positioning
                                                const position = element.tooltipPosition();
                                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
                                                ctx.fillText(text, position.x - 10, position.y - 5); // Adjust text placement
                                            });
                                        }
                                    });
                                }
                            }]
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
    </script>


    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>