<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!-- PDF.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

    <style>
        /* Styles for the viewer container */
        #pdf-viewer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: auto;
            /* Allows scrolling if needed */
        }

        /* PDF canvas responsiveness */
        canvas {
            max-width: 100%;
            height: auto;
            margin: 10px;
        }

        /* Adjustments for smaller screens */
        @media (max-width: 768px) {
            #pdf-viewer {
                padding: 10px;
            }

            canvas {
                max-width: 90%;
                /* Ensures canvas doesn't exceed viewport */
            }
        }

        @media (max-width: 480px) {
            canvas {
                max-width: 100%;
                /* Full width for very small screens */
            }
        }

        .pdf-page {
            margin: 10px;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 14px;
                /* Adjust the font size as needed */
            }

            .logo {
                max-width: 50px;
                /* Adjust the max-width of the logo */
                height: auto;
                /* Maintain aspect ratio */
            }

            body {
                padding-top: 70px;
                /* Add padding to the body to prevent navbar overlap */
            }
        }

        .navbar-brand {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }


        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
            /* Toggler border color */
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
        <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="../index.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>

    <div class="mt-1 mx-1 d-flex w-100  justify-content-end align-items-center">
        <!-- Back button -->
        <a href="view_pdf.php" class="btn text-secondary ">
            <i class="fas fa-times me-2"></i> Close
        </a>
    </div>

    <?php
    // Get the ID of the PDF file from the query parameter
    global $conn;
    $pdfId = isset($_GET['id']) ? $_GET['id'] : null;


    if ($pdfId) {
        require('../includes/dbcon.php');
        mysqli_query($conn, "UPDATE pdf_file SET views = views + 1 WHERE id = '$pdfId'");
        // Fetch the PDF file information using the ID
        $query = "SELECT pdf_name, pdf FROM pdf_file WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $pdfId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($pdfName, $pdfFile);
            $stmt->fetch();
    ?>
            <center>
                <h3 class="mt-1"><?= $pdfName ?></h3>
            </center>
            <div id="pdf-viewer"></div>

            <script>
                // PDF.js configuration options
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

                document.addEventListener('DOMContentLoaded', function() {
                    var pdfViewer = document.getElementById('pdf-viewer');
                    var pdfUrl = '../pdf/<?= $pdfFile ?>'; // Set the correct path to the PDF file

                    // Load the PDF document
                    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                        // Loop through each page
                        for (var pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                            // Fetch the page
                            pdf.getPage(pageNumber).then(function(page) {
                                var scale = 1.5;
                                var viewport = page.getViewport({
                                    scale: scale
                                });

                                // Prepare the canvas using PDF.js
                                var canvas = document.createElement('canvas');
                                var context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                // Render the page to the canvas
                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);

                                // Append the canvas to the viewer container
                                pdfViewer.appendChild(canvas);
                            }).catch(function(reason) {
                                console.error('Error rendering page: ' + reason);
                            });
                        }
                    }).catch(function(reason) {
                        console.error('Error loading PDF: ' + reason);
                    });
                });
            </script>
    <?php
        } else {
            echo "PDF not found.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid PDF ID.";
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>