<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum - Create Thread</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 50px;
    }

    .container {
      max-width: 600px;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .navbar-dark .navbar-toggler {
      border-color: #ffffff00;
    }
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

  <div class="container mt-3">

    <div class="mt-3 mb-3 d-flex w-100  justify-content-start align-items-center">
      <a href="thread.php" class="btn text-secondary ">
        <i class="fas fa-arrow-left me-2"></i> Back
      </a>
    </div>

    <?php
    require_once("../includes/dbcon.php");
    session_name('user_session');
    session_start();

    if (isset($_SESSION["user_id"])) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $user_id = $_SESSION["user_id"];

        $sql = "INSERT INTO threads (user_id, title, content)
                VALUES ($user_id, '$title', '$content')";

        if ($conn->query($sql) === TRUE) {
          header("Location: thread.php");
        } else {
          echo "Error creating thread: " . $conn->error;
        }
      } else {
    ?>

        <h4>New Post</h4>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="title">Title of your post:</label>
            <input type="text" class="form-control" id="title" name="title" required>
          </div>
          <div class="form-group">
            <label for="content">Message:</label>
            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
          </div>
          <button type="submit" class="btn btn-success"> <i class="fas fa-pencil-alt"></i> Create</button>
        </form>

    <?php
      }
    } else {
      header("Location: login.php");
    }

    $conn->close();
    ?>

  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>