<!-- view_thread.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - View Thread</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 56px;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 800px;
        }

        .thread-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .thread-info {
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .navbar {
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .back-button {
        display: none; /* Hidden by default */
    }

        .reply {
            margin-bottom: 15px;
        }

        .reply-author {
            font-weight: bold;
        }

        .reply-time {
            color: #aaa;
            font-size: 0.8rem;
            margin-left: 5px;
        }

        .centered-message {
            text-align: center;
            margin-top: 100px;
            font-size: 1.5rem;
            color: #666;
        }
        @media (max-width: 768px) {
        .back-button {
            display: inline-block; /* Visible on smaller screens */
        }
    }
    </style>
</head>

<body>

<nav class="navbar navbar-dark bg-success fixed-top shadow">
    <!-- Back Button -->
    <button class="btn btn-outline-light back-button" onclick="navigateBackToThreads()">Back to Threads</button>
</nav>

    <div class="container mt-4">
        <?php
        require_once("../includes/dbcon.php");
        session_name('user_session');
        session_start();

        if (!isset($_GET['id'])) {
            echo "<div class='centered-message'>Please select a post to view</div>";
            exit();
        }

        $thread_id = $_GET["id"];
        $current_user_id = $_SESSION["user_id"] ?? null;

        $sql = "SELECT t.*, u.username FROM threads t
                INNER JOIN users u ON t.user_id = u.id
                WHERE t.id = '$thread_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2 class='thread-title'>" . htmlspecialchars($row["title"]) . "</h2>";
            echo "<p class='thread-info'>Created by: " . htmlspecialchars($row["username"]) . " on " . $row["created_at"] . "</p>";

            echo "<div class='card mb-3'>";
            echo "  <div class='card-body'>";
            echo "    <div class='thread-content'>" . htmlspecialchars($row["content"]) . "</div>";
            echo "  </div>";
            echo "</div>";

            $sql_replies = "SELECT r.*, u.username FROM replies r
                            INNER JOIN users u ON r.user_id = u.id
                            WHERE r.thread_id = $thread_id
                            ORDER BY r.created_at ASC";
            $result_replies = $conn->query($sql_replies);
        } else {
            echo "<div class='centered-message'>Thread not found.</div>";
            exit();
        }
        ?>

        <h4 class="text-secondary">Replies</h4>
        <?php if (isset($result_replies) && $result_replies->num_rows > 0) { ?>
    <ul class="list-group">
        <?php while ($row_reply = $result_replies->fetch_assoc()) { 
            $isReplyOwner = $row_reply["user_id"] == $current_user_id; ?>
            <li class="list-group-item reply">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="reply-author"><?php echo htmlspecialchars($row_reply["username"]); ?></span>
                        <span class="reply-time"><?php echo date("F j, Y, g:i A", strtotime($row_reply["created_at"])); ?></span>
                    </div>
                    <?php if ($isReplyOwner) { ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownReply_<?php echo $row_reply["id"]; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownReply_<?php echo $row_reply["id"]; ?>">
                                <a class="dropdown-item text-success" href="#" onclick="confirmEdit(<?php echo $row_reply['id']; ?>, <?php echo $thread_id; ?>); return false;">Edit</a>
                                <a class="dropdown-item text-danger" href="#" onclick="deleteReply(<?php echo $row_reply['id']; ?>, this); return false;">Delete</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <p><?php echo htmlspecialchars($row_reply["content"]); ?></p>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No replies yet.</p>
<?php } ?>

        <h5 class="mt-4">Leave a Comment</h5>
        <form action="process_reply.php" method="POST">
            <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
            <div class="form-group">
                <textarea class="form-control" name="reply_content" rows="3" placeholder="Write your comment here..."></textarea>
            </div>
            <button type="submit" class="btn btn-success">Comment</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
function deleteReply(replyId, element) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#ffc107',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`delete_reply.php?id=${replyId}`, { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const replyElement = element.closest('.reply');
                        replyElement.remove();
                        Swal.fire('Deleted!', 'Your comment has been deleted.', 'success');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to delete comment.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error deleting reply:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred.',
                    });
                });
        }
    });
}

function confirmEdit(replyId, threadId) {
    Swal.fire({
        title: 'Edit your comment?',
        text: "You can modify your comment after this step.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#009d63',
        cancelButtonColor: '#ffc107',
        confirmButtonText: 'Yes, edit it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `edit_reply.php?reply_id=${replyId}&thread_id=${threadId}`;
        }
    });
}

        document.addEventListener('DOMContentLoaded', () => {
        // Add a back button on mobile view
        const backButton = document.createElement('button');
        backButton.innerText = 'Back to Threads';
        backButton.style = 'position: fixed; top: 10px; left: 10px; z-index: 1000;';
        backButton.className = 'btn btn-outline-success';
        backButton.onclick = () => {
            window.parent.navigateToThreads();
        };
        document.body.appendChild(backButton);
    });

  
        function navigateBackToThreads() {
            window.parent.navigateToThreads();
        }

    </script>

</body>

</html>