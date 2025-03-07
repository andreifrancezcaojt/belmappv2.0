<?php
require_once("../includes/dbcon.php");
session_name('user_session');
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $reply_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Verify ownership
    $sql = "SELECT id FROM replies WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $reply_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete reply
        $delete_sql = "DELETE FROM replies WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $reply_id);
        if ($delete_stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete reply.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Reply not found or access denied.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Reply ID not provided.']);
}
exit;
?>
