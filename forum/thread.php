<?php
session_name('user_session');
session_start();
require_once("../includes/dbcon.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 50px;
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    .container {
      max-width: 600px;
    }

    .thread-card {
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      margin-bottom: 20px;
      position: relative;
    }

    .thread-card-header {
      background-color: #ffffff;
      padding: 10px 15px;
      position: relative;
    }

    .thread-card-title {
      font-weight: bold;
      margin-bottom: 5px;
      font-size: 1.3rem;
    }

    .thread-card-title a {
      text-decoration: none;
      color: #000;
    }

    .thread-card-title.glowing-green a {
      color: #28a745;
    }

    .thread-card-info {
      color: #999;
      font-size: 0.8rem;
    }

    .dropdown {
      position: absolute;
      top: 10px;
      right: 15px;
    }

    .dropdown .dropdown-menu {
      z-index: 1050;
    }

    .footer {
      flex-shrink: 0;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
    }

    .navbar-brand {
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
    <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
    <a class="navbar-brand" href="../credentials/home.php">BASC E-Library</a>
  </nav>

  <div class="container mt-4">
    <div class="mb-5 d-flex w-100 align-items-center">
      <a href="../credentials/home.php" class="btn text-secondary justify-content-start" onclick="navigateHome(event)">
        <i class="fas fa-home"></i> Home
      </a>
      <form method="GET" action="" class="justify-content-end" onsubmit="return false;">
        <div class="input-group">
          <input type="text" id="searchInput" class="form-control" placeholder="Search posts..." aria-label="Search" aria-describedby="searchIcon" onkeyup="filterThreads()">
          <span class="input-group-text" id="searchIcon">
            <i class="fas fa-search"></i>
          </span>
        </div>
      </form>
    </div>

    <!-- Create Thread Button -->
    <div class="mb-4">
      <a href="thread_create.php" class="btn btn-success w-100">
        <i class="fas fa-plus"></i> Add Post
      </a>
    </div>

    <!-- Threads -->
    <div id="threadsContainer">
      <?php
      if (isset($_SESSION["user_id"])) {
        $current_user_id = $_SESSION["user_id"];
        $sql = "SELECT t.*, u.username FROM threads t
                INNER JOIN users u ON t.user_id = u.id
                ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $isOwnedByUser = $row["user_id"] == $current_user_id;
            echo "<div class='card thread-card' id='thread_" . $row["id"] . "'>";
            echo "<div class='card-header thread-card-header'>";

            // Thread title and info
            $titleClass = $isOwnedByUser ? "glowing-green" : "";
            echo "<h3 class='card-title thread-card-title $titleClass'>
                    <a href='view_thread.php?id=" . $row["id"] . "' target='right_frame' 
                       onclick=\"parent.postMessage('navigateToView', '*');\">
                       " . $row["title"] . "
                    </a>
                  </h3>";
            echo "<p class='card-text thread-card-info ml-4'>Created by: " . $row["username"] . " on " . $row["created_at"] . "</p>";
            

            // Add three dots dropdown menu if the current user created the thread
            if ($isOwnedByUser) {
              echo "<div class='dropdown'>";
              echo "<button class='btn btn-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton_" . $row["id"] . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
              echo "<i class='fas fa-ellipsis-v'></i>";
              echo "</button>";
              echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton_" . $row["id"] . "'>";
              echo "<a class='dropdown-item text-success' href='#' onclick=\"confirmEdit(" . $row["id"] . "); return false;\">Edit</a>";
              echo "<a class='dropdown-item text-danger' href='#' onclick=\"confirmDelete(" . $row["id"] . "); return false;\">Delete</a>";
              echo "</div>";
              echo "</div>";
            }

            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "No threads found.";
        }
      } else {
        header("Location: login.php");
      }
      $conn->close();
      ?>
    </div>
  </div>

  <footer class="footer mt-auto py-3">
    <div class="container text-center">
      <!-- Modal Trigger Button -->
      <button type="button" class="btn btn-outline-success mb-2 rounded-circle" data-toggle="modal" data-target="#messageModal" style="width: 60px; height: 60px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
        <i class="fas fa-user-tie" style="font-size: 24px;"></i>
      </button><br>
      <span class="text-muted">© <?php echo date("Y"); ?> BELMApp v2.0 | Bulacan Agricultural State College.</span>
    </div>
  </footer>

  <!-- Message Modal -->
  <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="messageModalLabel">Send a Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="send_message.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" required>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your message" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-success">Send Message</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function filterThreads() {
      const input = document.getElementById('searchInput').value.trim().toLowerCase();
      const threads = document.getElementsByClassName('thread-card');
      for (let i = 0; i < threads.length; i++) {
        const titleElement = threads[i].getElementsByClassName('thread-card-title')[0];
        if (titleElement) {
          const title = titleElement.innerText.trim().toLowerCase();
          threads[i].style.display = title.includes(input) ? 'block' : 'none';
        }
      }
    }

    function navigateHome(event) {
      event.preventDefault();
      window.top.location.href = "../credentials/home.php";
    }

    function confirmEdit(threadId) {
      Swal.fire({
        title: 'Edit this thread?',
        text: "You can modify your thread after this step.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#009d63',
        cancelButtonColor: '#ffc107',
        confirmButtonText: 'Yes, edit it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `edit_thread.php?id=${threadId}`;
        }
      });
    }

    function confirmDelete(threadId) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#ffc107',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`delete_thread.php?id=${threadId}`, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                const threadElement = document.getElementById(`thread_${threadId}`);
                if (threadElement) threadElement.remove();
                Swal.fire('Deleted!', data.message, 'success');
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message || 'Failed to delete thread.',
                });
              }
            })
            .catch(error => {
              console.error('Error deleting thread:', error);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.',
              });
            });
        }
      });
    }
  </script>
</body>

</html>
