<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum - Edit Thread</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
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
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top shadow">
      <div class="brand-container">
          <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo">
      </div>
      <a class="navbar-brand" href="../credentials/home.php">BASC E-Library</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                  <a class="nav-link" href="../credentials/home.php">Home</a>
              </li>
          </ul>
      </div>
    </nav>

  <div class="container mt-5">

    <?php
    require_once("../includes/dbcon.php");
    session_name('user_session');
session_start();

    // Check if user is logged in
    if (!isset($_SESSION["user_id"])) {
      header("Location: login.php");
      exit;
    }

    // Check if form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Validate form data
      if (empty($_POST["editTitle"]) || empty($_POST["editContent"])) {
        echo "All fields are required.";
      } else {
        $user_id = $_SESSION["user_id"];
        $editTitle = $_POST["editTitle"];
        $editContent = $_POST["editContent"];
        $editThreadId = $_POST["editThreadId"];

        // Update the thread in the database
        $sql = "UPDATE threads SET title=?, content=? WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $editTitle, $editContent, $editThreadId, $user_id);
        
        if ($stmt->execute()) {
          header("Location: thread.php");
        } else {
          echo "Error updating thread: " . $conn->error;
        }

        $stmt->close();
      }
    } else {
      // Fetch thread data for editing
      $thread_id = $_GET["id"];

      $sql = "SELECT title, content FROM threads WHERE id=? AND user_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $thread_id, $_SESSION["user_id"]);
      $stmt->execute();
      $result = $stmt->get_result();
      $thread = $result->fetch_assoc();
    ?>
    <!-- Edit Thread Form -->
    <h2>Edit Thread</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="editTitle">Title:</label>
        <input type="text" class="form-control" id="editTitle" name="editTitle" value="<?php echo $thread['title']; ?>" required>
      </div>
      <div class="form-group">
        <label for="editContent">Content:</label>
        <textarea class="form-control" id="editContent" name="editContent" rows="5" required><?php echo $thread['content']; ?></textarea>
      </div>
      <input type="hidden" id="editThreadId" name="editThreadId" value="<?php echo $thread_id; ?>">
      <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
    <?php
    }
    ?>

  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
