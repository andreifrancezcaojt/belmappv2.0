<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Access Databases</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 70px;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .navbar-brand {
            color: #fff;
            text-decoration: none;
            font-weight: 800;
            font-size: 20px;
        }

        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
        }

        .card {
            width: 100%;
            height: 200px;
            margin-bottom: 20px;
            margin-top: 40px;
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            /* Light gray background */
        }

        .card:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            /* Slightly larger shadow on hover */
        }

        .card-image {
            width: 150px;
            /* Adjust the width as needed */
            height: 100px;
            /* Adjust the height as needed */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin: 10px auto 10px;
        }

        .card-image img {
            width: 150px;
            /* Make the image fill the container */
            height: 150px;
            /* Make the image fill the container */
            object-fit: contain;
            /* Maintain aspect ratio and cover the container */
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            /* Dark text color */
            margin-top: 10px;
            /* Add some space above the title */
        }

        .card-body {
            padding: 15px;
            /* Add padding to the card body */
        }

        .jumbotron {
            /* background-color: #fff; */
            background-color: #fff;
            border-radius: 5px;
            color: #000;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            max-width: 90%;
            padding-bottom: 40px;
        }

        .input-group-text {
            padding: 0.375rem 0.75rem;
            /* Matches input-group-sm size */
            font-size: 0.875rem;
            /* Optional: Adjusts icon to the same font size */
            line-height: 1.5;
        }

        .text-main {
            font-size: 20px;
        }

        #modalTitle {
            font-size: 18px;
            /* Adjust the size to make the title smaller */
            font-weight: bold;

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
        }

        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 100%;

                /* Allow more space on smaller screens */
            }

            .modal-body {
                padding: 15px;
                /* Adjust padding on smaller screens */
            }
        }

        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 100%;

            }
        }

        .filter-btn {
            margin: 0 5px;
        }

        .card-item {
            transition: all 0.3s ease-in-out;
        }
    </style>
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
        <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="../credentials/home.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>


    <div class="mb-3 d-flex w-100  justify-content-center align-items-center">

        <!-- Home button -->
        <a href="../credentials/home.php" class="btn text-secondary justify-content-start">
            <i class="fas fa-home"></i> Home
        </a>

        <!-- Search bar -->
        <form method="GET" action="" class="justify-content-end mr-3" onsubmit="return false;">
            <div class="input-group">
                <input
                    type="text"
                    id="searchInput"
                    class="form-control"
                    placeholder="Search database..."
                    aria-label="Search"
                    aria-describedby="searchIcon"
                    onkeyup="filterThreads()">
                <span class="input-group-text" id="searchIcon">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </form>

    </div>

    <center>
        <div class="jumbotron py-1">
            <h3 class="text-main" style="font-size: 2rem;">Open Access Databases</h3>
            <hr class="my-2">
            <p>Our collection includes unrestricted access to knowledge that fuels curiosity
                and drives innovation, courtesy of revolutionary research to comprehensive
                analysis. </p>
        </div>
    </center>

    <?php
    require('../includes/dbcon.php');

    // Fetch categories
    $query = "SELECT id, oadb_name, oadb_url, image, category FROM open_access_db WHERE is_archived = 0";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo '<div class="container">';

        // Add filter buttons
        echo '
    <div class="col text-center">
    <div class="row">
        <div class="col">
            <button class="btn btn-success filter-btn w-100" data-category="all">
                <i class="bi bi-funnel"></i> All
            </button>
        </div>
        <div class="col">
            <button class="btn btn-success filter-btn w-100" data-category="free">
                <i class="bi bi-funnel"></i> Free
            </button>
        </div>
        <div class="col">
            <button class="btn btn-success filter-btn w-100" data-category="paid">
                <i class="bi bi-funnel"></i> Paid
            </button>
        </div>
    </div>
</div>

<!-- Include Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

';

        // Cards container
        echo '<div class="row" id="cardContainer">';
        while ($row = $result->fetch_assoc()) {
            $categoryClass = strtolower($row['category']); // Normalize category to lowercase for consistency
    ?>
            <div class="col-md-3 card-column card-item <?php echo $categoryClass; ?>">
                <div class="card" onclick="openModal('<?php echo $row["oadb_url"]; ?>', '<?php echo $row["oadb_name"]; ?>')">
                    <div class="card-image">
                        <img src="../uploadedDB/<?php echo $row['image']; ?>" alt="<?php echo $row['oadb_name']; ?>" class="img-fluid">
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a class="text-dark" href="#" style="color: #007bff; text-decoration:none !important"><?php echo $row["oadb_name"]; ?></a>
                        </h6>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="cardModalLabel">BELMAPPv2.0</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding: 0;">
                            <h3 id="modalTitle" style="padding: .2rem;"></h3>
                            <iframe id="modalIframe" src="" width="100%" height="550px" style="border: none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>



    <?php
        }
        echo '</div>'; // End of card container
        echo '</div>'; // End of container
    } else {
        echo "0 results";
    }
    ?>
    <script>
        // JavaScript for filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const cardItems = document.querySelectorAll('.card-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const category = button.getAttribute('data-category');

                    cardItems.forEach(card => {
                        if (category === 'all' || card.classList.contains(category)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>


    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script>
        // JavaScript to open the modal and insert the card information dynamically
        function openModal(url, name) {
            // Set the modal title
            document.getElementById('modalTitle').textContent = name;

            // Set the iframe src to the provided URL to load the content inside the modal
            document.getElementById('modalIframe').src = url;

            // Open the modal
            $('#cardModal').modal('show');
        }

        function searchDatabase() {
            var input = document.getElementById('searchInput').value.trim().toLowerCase(); // Get the trimmed input value and convert it to lowercase
            var cards = document.getElementsByClassName('card-column'); // Get all card column elements

            // Loop through each card to filter by title
            for (var i = 0; i < cards.length; i++) {
                var title = cards[i].getElementsByClassName('card-title')[0].innerText.trim().toLowerCase(); // Get the card title

                // Check if the input is empty or if the title contains the search input (case-insensitive)
                if (input === '' || title.indexOf(input) !== -1) {
                    cards[i].style.display = 'block'; // Show the card if it matches
                } else {
                    cards[i].style.display = 'none'; // Hide the card if it doesn't match
                }
            }
        }


        // Add an event listener to the search input field so it calls the searchDatabase function on every keyup
        document.getElementById('searchInput').addEventListener('keyup', searchDatabase);
    </script>

    <!-- Bootstrap JS and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>