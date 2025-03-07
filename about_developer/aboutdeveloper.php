<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Developers</title>

  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 15px;
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    .card-img-top {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      margin: auto;
      margin-bottom: 5px;
    }

    .card {
      margin-bottom: 20px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .navbar-dark .navbar-toggler {
      border-color: #ffffff00;
    }

    .footer {
      background-color: #f8f9fa;
      padding: 10px 0;
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

<body class="d-flex flex-column min-vh-100">

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

  <main class="flex-grow-1 container my-5">

    <div class="mt-2 mb-1  d-flex w-100  justify-content-start align-items-center">

      <a href="../credentials/home.php" class="btn text-secondary ">
        <i class="fas fa-arrow-left me-2"></i> Back
      </a>

    </div>

    <h4 class="text-center mb-4 mt-1">BELMAppv2.0 Developers</h4>

    <div class="row g-4">
      <!-- Developer 1 -->
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card h-100 shadow-sm" style="background-color: #fff;">
          <div class="d-flex flex-column flex-md-row align-items-center p-3">
            <img src="../assets/developer/andrei.png" alt="Developer 1" class="img-fluid rounded-circle mb-3 mb-md-0 me-md-3" style="width: 150px; height: 150px; object-fit: cover;">
            <div class="text-wrap text-start ml-3">
              <h5 class="card-title mb-0">Andrei Francezca Gonzales</h5>
              <p class="card-title text-success"><strong>Programmer /Data Analyst</strong></p>
              <p class="mb-1"><strong><i class="fas fa-envelope mr-1"></i> </strong> andreifrancezcagonzales.basc@gmail.com</p>
              <p class="mb-1"><strong><i class="fab fa-facebook mr-1"></i> </strong> <a href="https://web.facebook.com/Francezca.Gonzales16" target="_blank" class="text-dark text-decoration-none">Andrei Francezca Gonzales</a></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Developer 2 -->
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card h-100 shadow-sm" style="background-color: #fff;">
          <div class="d-flex flex-column flex-md-row align-items-center p-3">
            <img src="../assets/developer/kier.jpg" alt="Developer 2" class="img-fluid rounded-circle mb-3 mb-md-0 me-md-3" style="width: 150px; height: 150px; object-fit: cover;">
            <div class="text-wrap text-start ml-3">
              <h5 class="card-title mb-0">Kier Quizon</h5>
              <p class="card-title text-success"><strong> Programmer /Graphic Designer</strong></p>
              <p class="mb-1"><strong><i class="fas fa-envelope mr-1"></i></strong> kierquizon.basc@gmail.com</p>
              <p class="mb-1"><strong><i class="fab fa-facebook mr-1"></i></strong> <a href="https://www.facebook.com/Quizonkier" target="_blank" class="text-dark text-decoration-none">Kier Quizon</a></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Developer 3 -->
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card h-100 shadow-sm" style="background-color: #fff;">
          <div class="d-flex flex-column flex-md-row align-items-center p-3">
            <img src="../assets/developer/paula.png" alt="Developer 3" class="img-fluid rounded-circle mb-3 mb-md-0 me-md-3" style="width: 150px; height: 150px; object-fit: cover;">
            <div class="text-wrap text-start ml-3">
              <h5 class="card-title mb-0">Paula Mae Samaniego</h5>
              <p class="card-title text-success"><strong> Project Manager /Data Analyst</strong></p>
              <p class="mb-1"><strong><i class="fas fa-envelope mr-1"></i></strong> paulamaesamaniego.basc@gmail.com</p>
              <p class="mb-1"><strong><i class="fab fa-facebook mr-1"></i></strong> <a href="https://web.facebook.com/paulamae.samaniego.9" target="_blank" class="text-dark text-decoration-none">Paula Mae Samaniego</a></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Developer 4 -->
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card h-100 shadow-sm" style="background-color: #fff;">
          <div class="d-flex flex-column flex-md-row align-items-center p-3">
            <img src="../assets/developer/demitri.jpg" alt="Developer 4" class="img-fluid rounded-circle mb-3 mb-md-0 me-md-3" style="width: 150px; height: 150px; object-fit: cover;">
            <div class="text-wrap text-start ml-3">
              <h5 class="card-title mb-0">Demitri Ivan Peralta</h5>
              <p class="card-title text-success"><strong>Programmer /Graphic Designer</strong></p>
              <p class="mb-1"><strong><i class="fas fa-envelope mr-1"></i></strong> demitriivanperalta.basc@gmail.com</p>
              <p class="mb-1"><strong><i class="fab fa-facebook mr-1"></i></strong> <a href="https://web.facebook.com/demitri.inovero" target="_blank" class="text-dark text-decoration-none">Demitri Peralta</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer mt-auto text-center py-2">
    <div class="container">
      <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
    </div>
  </footer>

  <!-- Bootstrap JS and jQuery scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>