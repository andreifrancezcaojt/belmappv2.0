<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View E-Resources</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Font Awesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        /* Styles for cards and container */
        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card {
            border-radius: 15px;
            width: 100%;
            /* Cards take full width of their container */
            max-width: 300px;
            /* Maximum width on larger screens */
            height: auto;
            /* Allow cards to adjust height based on content */
            transition: transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
        }

        .btn-primary {
            margin-top: auto;
            font-size: 15px;
        }

        .rating-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .star {
            font-size: 25px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star:hover,
        .star.selected {
            color: #f39c12;
        }

        .star:hover {
            color: #f39c12;
        }

        .jumbotron {
            background-color: #fff;
            border-radius: 5px;
            max-width: 90%;
            color: #000;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding-bottom: 20px;
            padding: 40px;
        }

        .star-rating {
            display: flex;
            font-size: 20px;
            justify-content: center;
        }


        .star-rating .fa-star.checked {
            color: #f39c12;
        }

        .rating-container {
            justify-content: center;
        }

        /* Media Queries for responsiveness */
        @media (max-width: 1200px) {

            /* Adjust card sizes for large screens */
            .card {
                max-width: 280px;
            }

            .jumbotron {
                max-width: 95%;
                /* Slightly smaller jumbotron */
            }
        }

        @media (max-width: 992px) {

            /* For medium screens */
            .card {
                max-width: 250px;
            }

            .jumbotron {
                max-width: 95%;
                padding: 30px;
            }
        }

        @media (max-width: 768px) {

            /* Adjust for tablets and small screens */
            .jumbotron {
                max-width: 100%;
                padding: 20px;
            }

            .card {
                max-width: 200px;
                height: auto;
            }

            /* Make the navbar form more responsive */
            .navbar .form-inline {
                display: block;
                width: 100%;
            }

            /* Align navbar items centrally */
            .navbar-nav {
                justify-content: center;
                width: 100%;
            }

            /* Adjust star size */
            .star {
                font-size: 15px;
            }

            .rating-value {
                font-size: 13px;
            }
        }

        @media (max-width: 576px) {

            /* For very small screens */
            .card {
                max-width: 100%;
                margin-bottom: 15px;
                justify-content: center;
            }

            /* Make rating stars smaller */
            .star {
                font-size: 14px;
            }

            /* Reduce padding in jumbotron */
            .jumbotron {
                /* background-color: #fff; */
                background-color: #fff;
                border-radius: 5px;
                color: #000;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
                max-width: 90%;
                padding-bottom: 40px;
            }

            /* Stack navbar links vertically */
            .navbar-nav {
                flex-direction: column;
            }

            /* Adjust search box */
            .form-control {
                width: 100%;
            }

            /* Adjust button size for smaller screens */
            /* .btn {
                width: 100%;
            } */

            .rating-value {
                font-size: 12px;
            }
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
    </style>
</head>

<body>
    <!-- NAVBAR -->
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

    <div class="mt-3 mb-3 d-flex w-100  justify-content-center align-items-center">

        <!-- Home button -->
        <a href="../credentials/home.php" class="btn text-secondary ">
            <i class="fas fa-home"></i> Home
        </a>

        <!-- Search bar -->
        <form method="GET" action="" class="mr-3" onsubmit="return false;">
            <div class="input-group">
                <input
                    type="text"
                    id="searchInput"
                    class="form-control"
                    placeholder="Search e-books..."
                    aria-label="Search"
                    aria-describedby="searchIcon"
                    onkeyup="searchEbooks()">
                <span class="input-group-text" id="searchIcon">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </form>

    </div>

    <center>
        <div class="jumbotron py-2">
            <h2 class="text-main">Electronic Resources</h2>
            <hr class="my-2">
            <p>Explore our extensive digital library of e-books, articles, journals, and more.</p>
        </div>
    </center>

    <!-- TOP 3 BOOKS -->
    <div class="container mb-5">

        <div class="row">
            <!-- Filter by Category -->
            <div class="col-md-12 mb-3">
                <form method="GET" action="" id="filterForm">
                    <div class="form-row align-items-center justify-content-center">
                        <div class="col-auto">
                            <div class="input-group">
                                <select name="category" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                    <option value="">All Categories</option>
                                    <?php
                                    require_once "../includes/dbcon.php"; // Use require_once

                                    // Fetch categories from the database
                                    $category_query = "SELECT DISTINCT category FROM pdf_file";
                                    $category_result = $conn->query($category_query);

                                    if ($category_result->num_rows > 0) {
                                        while ($row = $category_result->fetch_assoc()) {
                                            $selected = isset($_GET['category']) && $_GET['category'] == $row['category'] ? 'selected' : '';
                                            echo "<option value='{$row['category']}' {$selected}>{$row['category']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-filter"></i> <!-- Filter icon -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <h3 class="text-center ">Top Rated E-Resources</h3>
            </div>
        </div>
        <br>

        <div class="row">
            <?php
            require_once '../includes/dbcon.php'; // Use require_once here too

            // Fetch books based on category filter
            $category_filter = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
            $query = "SELECT id, pdf_name, pdf, category FROM pdf_file WHERE is_archived = 0";
            if ($category_filter) {
                $query .= " AND category = '$category_filter'";
            }

            $result = $conn->query($query);
            $books = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pdf_id = $row['id'];

                    // Fetch average rating from the database for this PDF
                    $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE pdf_id = $pdf_id";
                    $rating_result = $conn->query($rating_query);
                    $avg_rating = $rating_result->fetch_assoc()['avg_rating'];
                    $avg_rating = round($avg_rating, 1);

                    $books[] = [
                        'id' => $row['id'],
                        'pdf_name' => $row['pdf_name'],
                        'category' => $row['category'],
                        'avg_rating' => $avg_rating
                    ];
                }
            }

            // Sort books by rating
            usort($books, function ($a, $b) {
                return $b['avg_rating'] <=> $a['avg_rating'];
            });

            // Split books into top 3
            $top_books = array_slice($books, 0, 3);

            // Display filtered books
            foreach ($top_books as $book) {
                $pdf_id = $book['id'];
                $avg_rating = $book['avg_rating'];
                $full_stars = floor($avg_rating);
                $half_star = ($avg_rating - $full_stars) >= 0.5 ? true : false;
                $empty_stars = 5 - ($full_stars + ($half_star ? 1 : 0));
            ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= $book["pdf_name"] ?></h5>
                            <h6 class="card-title text-center text-muted"><?= $book["category"] ?></h6>
                            <div class="rating-container">
                                <div class="star-rating">
                                    <?php for ($i = 0; $i < $full_stars; $i++) { ?>
                                        <i class="fa fa-star star checked"></i>
                                    <?php } ?>
                                    <?php if ($half_star) { ?>
                                        <i class="fa fa-star-half-alt star checked"></i>
                                    <?php } ?>
                                    <?php for ($i = 0; $i < $empty_stars; $i++) { ?>
                                        <i class="fa fa-star star"></i>
                                    <?php } ?>
                                </div>
                                <span class="rating-value"><?= $avg_rating ?> Rating</span>
                            </div>
                            <center>
                                <button class="btn btn-outline-warning btn-sm btn-block mb-1" data-toggle="modal" data-target="#ratingModal-<?= $pdf_id ?>">Rate</button>
                                <a href="pdf_viewer.php?id=<?= $pdf_id ?>" class="btn btn-success btn-block btn-sm">Open File</a>
                            </center>
                        </div>
                    </div>
                </div>
                
                                <!-- Rating Modal -->
                <div class="modal fade" id="ratingModal-<?= $pdf_id ?>" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel-<?= $pdf_id ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ratingModalLabel-<?= $pdf_id ?>">Rate the e-resource: "<?= $book["pdf_name"] ?>"</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <center>
                                    <form id="ratingForm-<?= $pdf_id ?>" method="POST" action="submit_rating.php" onsubmit="return validateRating(<?= $pdf_id ?>)">
                                        <input type="hidden" name="pdf_id" value="<?= $pdf_id ?>">
                                        <div class="form-group">
                                            <label for="rating"><b>Help Us Improve Our Collection!</b></label>
                                            <label for="rating">Rate this e-resource and share your thoughts to help us offer the best selections.</label>
                                            <div class="star-rating">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star star" data-value="<?= $i ?>" onclick="selectRating(<?= $i ?>, <?= $pdf_id ?>)"></i>
                                                <?php } ?>
                                            </div>
                                            <!-- Hidden rating input to store selected value -->
                                            <input type="hidden" name="rating" id="ratingInput-<?= $pdf_id ?>" value="" required>
                                            <p id="validationMessage-<?= $pdf_id ?>" style="color: red; display: none;">Please select a rating between 1 and 5.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Comment (Optional):</label>
                                            <textarea class="form-control" name="comment" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                
            <?php } ?>
        </div>
    </div>



    <!-- OTHER BOOKS -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center ">Other E-Resources</h3>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            require_once '../includes/dbcon.php'; // Ensure the database connection is included only once

            // Fetch other books based on category filter
            $category_filter = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
            $query = "SELECT id, pdf_name, pdf, category FROM pdf_file WHERE is_archived = 0";
            if ($category_filter) {
                $query .= " AND category = '$category_filter'";
            }

            $result = $conn->query($query);
            $books = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pdf_id = $row['id'];

                    // Fetch average rating from the database for this PDF
                    $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE pdf_id = $pdf_id";
                    $rating_result = $conn->query($rating_query);
                    $avg_rating = $rating_result->fetch_assoc()['avg_rating'];
                    $avg_rating = round($avg_rating, 1);

                    $books[] = [
                        'id' => $row['id'],
                        'pdf_name' => $row['pdf_name'],
                        'category' => $row['category'],
                        'avg_rating' => $avg_rating
                    ];
                }
            }

            // Separate into top books and other books
            usort($books, function ($a, $b) {
                return $b['avg_rating'] <=> $a['avg_rating'];
            });

            $top_books = array_slice($books, 0, 3);
            $other_books = array_slice($books, 3);

            // Display other books
            foreach ($other_books as $book) {
                $pdf_id = $book['id'];
                $avg_rating = $book['avg_rating'];
                $full_stars = floor($avg_rating);
                $half_star = ($avg_rating - $full_stars) >= 0.5 ? true : false;
                $empty_stars = 5 - ($full_stars + ($half_star ? 1 : 0));
            ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= $book["pdf_name"] ?></h5>
                            <h6 class="card-title text-center text-muted"><?= $book["category"] ?></h6>
                            <div class="rating-container">
                                <div class="star-rating">
                                    <?php for ($i = 0; $i < $full_stars; $i++) { ?>
                                        <i class="fa fa-star star checked"></i>
                                    <?php } ?>
                                    <?php if ($half_star) { ?>
                                        <i class="fa fa-star-half-alt star checked"></i>
                                    <?php } ?>
                                    <?php for ($i = 0; $i < $empty_stars; $i++) { ?>
                                        <i class="fa fa-star star"></i>
                                    <?php } ?>
                                </div>
                                <span class="rating-value"><?= $avg_rating ?> Rating</span>
                            </div>
                            <center>
                                <button class="btn btn-outline-warning btn-block btn-sm mb-1" data-toggle="modal" data-target="#ratingModal-<?= $pdf_id ?>">Rate</button>
                                <a href="pdf_viewer.php?id=<?= $pdf_id ?>" class="btn btn-success btn-block btn-sm">Open File</a>
                            </center>
                        </div>
                    </div>
                </div>

                <!-- Rating Modal -->
                <div class="modal fade" id="ratingModal-<?= $pdf_id ?>" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel-<?= $pdf_id ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ratingModalLabel-<?= $pdf_id ?>">Rate the e-resource: "<?= $book["pdf_name"] ?>"</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <center>
                                    <form id="ratingForm-<?= $pdf_id ?>" method="POST" action="submit_rating.php" onsubmit="return validateRating(<?= $pdf_id ?>)">
                                        <input type="hidden" name="pdf_id" value="<?= $pdf_id ?>">
                                        <div class="form-group">
                                            <label for="rating"><b>Help Us Improve Our Collection!</b></label>
                                            <label for="rating">Rate this e-resource and share your thoughts to help us offer the best selections.</label>
                                            <div class="star-rating">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star star" data-value="<?= $i ?>" onclick="selectRating(<?= $i ?>, <?= $pdf_id ?>)"></i>
                                                <?php } ?>
                                            </div>
                                            <!-- Hidden rating input to store selected value -->
                                            <input type="hidden" name="rating" id="ratingInput-<?= $pdf_id ?>" value="" required>
                                            <p id="validationMessage-<?= $pdf_id ?>" style="color: red; display: none;">Please select a rating between 1 and 5.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment">Comment (Optional):</label>
                                            <textarea class="form-control" name="comment" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                                    </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <script>
        // Function to handle star rating selection
        function selectRating(value, pdf_id) {
            // Set the rating value in the hidden input
            document.getElementById('ratingInput-' + pdf_id).value = value;

            // Update the appearance of the stars based on the rating
            const stars = document.querySelectorAll('#ratingModal-' + pdf_id + ' .star');
            stars.forEach(star => {
                const starValue = parseInt(star.getAttribute('data-value'));
                if (starValue <= value) {
                    star.classList.add('selected'); // Add selected class for filled stars
                } else {
                    star.classList.remove('selected'); // Remove selected class for unfilled stars
                }
            });
        }

        // Validation function to ensure rating is selected
        function validateRating(pdf_id) {
            const rating = document.getElementById('ratingInput-' + pdf_id).value;
            const validationMessage = document.getElementById('validationMessage-' + pdf_id);

            if (rating < 1 || rating > 5) {
                validationMessage.style.display = 'block';
                return false;
            }

            validationMessage.style.display = 'none';
            return true;
        }

        function searchEbooks() {
            var input = document.getElementById('searchInput').value.trim().toLowerCase(); // Get the search input and normalize
            var cards = document.getElementsByClassName('card'); // Get all cards
            var cardContainer = document.querySelector('.row'); // Get the card container (row)

            // Hide/show cards based on search
            for (var i = 0; i < cards.length; i++) {
                var title = cards[i].getElementsByClassName('card-title')[0]?.innerText.trim().toLowerCase(); // Get the card title

                // If the title includes the input or the input is empty, show the card
                if (input === '' || title.includes(input)) {
                    cards[i].style.display = 'block'; // Show matching card
                } else {
                    cards[i].style.display = 'none'; // Hide non-matching card
                }
            }


            // Adjust layout to avoid gaps by recalculating flex layout
            cardContainer.style.display = 'flex'; // Ensure the container uses flex layout
            cardContainer.style.flexWrap = 'wrap'; // Wrap items to maintain alignment
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get("status");

            if (status === "success") {
                Swal.fire({
                    title: 'Thank you!',
                    text: 'Your rating was submitted!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Remove the query parameter from the URL
                    window.history.replaceState(null, null, window.location.pathname);
                });
            } else if (status === "error") {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Remove the query parameter from the URL
                    window.history.replaceState(null, null, window.location.pathname);
                });
            }
        });
    </script>




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>