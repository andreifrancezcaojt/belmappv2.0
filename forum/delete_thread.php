<?php
require_once("../includes/dbcon.php");

if (isset($_GET['id'])) {
    $threadId = intval($_GET['id']);
    $sql = "DELETE FROM threads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $threadId);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Thread deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete the thread."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid thread ID."]);
}

$conn->close();