<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/icon/library_logo_nbg.png">
  <title>Developers | BELMAppv2.0</title>

  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <style>
.card-container {
  width: 100%;
  perspective: 2000px; /* Mas malalim na 3D */
  display: flex;
  align-items: center;
  justify-content: center;
}

.card {
  width: 420px;
  height: 330px;
  transform-style: preserve-3d;
  transition: transform 0.9s ease-in-out;
  position: relative;
  transform: rotateY(0deg);
}

.card:hover {
  transform: rotateY(180deg) scale(1.1) rotateX(10deg); /* 3D FLIP + ZOOM + ANGLE */
  box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.2); /* Soft shadow */
}

.card-front, 
.card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 20px;
  background: white; /* WHITE DESIGN */
  border-radius: 15px;
  box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
  transform: rotateY(0deg);
  color: black;
}

.card-front img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
  margin-bottom: 12px;
  border: 4px solid rgba(0, 0, 0, 0.1);
}

.card-back {
  transform: rotateY(180deg);
}

.card-container:hover .card-front {
  filter: blur(3px) brightness(0.9); /* Fade effect */
}

.card-back p, 
.card-back a {
  font-size: 1.1em;
  transition: transform 0.3s ease-in-out;
  color: black;
  word-wrap: break-word;
  max-width: 110%;
}

.card-back:hover p, 
.card-back:hover a {
  transform: scale(1.1); /* Lumalaki konti pag hover sa likod */
}

/* Mobile responsiveness */
@media (max-width: 768px) {
  .card-container {
    perspective: 1500px; /* Less depth on mobile */
  }

  .card {
    width: 90%;  /* Adjust card width for smaller screens */
    height: auto; /* Make height adjust automatically */
  }

  .card-front img {
    width: 120px; /* Smaller image on mobile */
    height: 120px;
  }

  .card-back p, 
  .card-back a {
    font-size: 1em; /* Adjust text size */
  }
}
</style>
</head>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/67dbb244b85872190f4479f9/1imp30n70';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


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

    <div class="row g-4 justify-content-center">
  <!-- Developer 1 -->
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card-container">
      <div class="card">
        <!-- Front Side -->
        <div class="card-front">
          <img src="../assets/developer/andrei.png" alt="Andrei Francezca Gonzales">
          <h5>Andrei Francezca Gonzales</h5>
          <p class="text-success fw-bold">Programmer / Data Analyst</p>
        </div>
        <!-- Back Side -->
        <div class="card-back">
          <p><i class="fas fa-envelope"></i> andreifrancezcagonzales.basc@gmail.com</p>
          <p><i class="fab fa-facebook"></i> 
            <a href="https://web.facebook.com/Francezca.Gonzales16" target="_blank">Andrei Francezca Gonzales</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Developer 2 -->
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card-container">
      <div class="card">
        <div class="card-front">
          <img src="../assets/developer/kier.jpg" alt="Kier Quizon">
          <h5>Kier Quizon</h5>
          <p class="text-success fw-bold">Programmer / Graphic Designer</p>
        </div>
        <div class="card-back">
          <p><i class="fas fa-envelope"></i> kierquizon.basc@gmail.com</p>
          <p><i class="fab fa-facebook"></i> 
            <a href="https://www.facebook.com/Quizonkier" target="_blank">Kier Quizon</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Developer 3 -->
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card-container">
      <div class="card">
        <div class="card-front">
          <img src="../assets/developer/paula.png" alt="Paula Mae Samaniego">
          <h5>Paula Mae Samaniego</h5>
          <p class="text-success fw-bold">Project Manager / Data Analyst</p>
        </div>
        <div class="card-back">
          <p><i class="fas fa-envelope"></i> paulamaesamaniego.basc@gmail.com</p>
          <p><i class="fab fa-facebook"></i> 
            <a href="https://web.facebook.com/paulamae.samaniego.9" target="_blank">Paula Mae Samaniego</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Developer 4 -->
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card-container">
      <div class="card">
        <div class="card-front">
          <img src="../assets/developer/demitri.jpg" alt="Demitri Ivan Peralta">
          <h5>Demitri Ivan Peralta</h5>
          <p class="text-success fw-bold">Programmer / Graphic Designer</p>
        </div>
        <div class="card-back">
          <p><i class="fas fa-envelope"></i> demitriivanperalta.basc@gmail.com</p>
          <p><i class="fab fa-facebook"></i> 
            <a href="https://web.facebook.com/demitri.inovero" target="_blank">Demitri Peralta</a>
          </p>
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