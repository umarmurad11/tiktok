<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video_id = $_POST['video_id'];
    $user_id = $_SESSION['user_id']; // Ensure user is logged in.

    // Prevent duplicate likes.
    $checkQuery = "SELECT * FROM likes WHERE video_id = ? AND user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $video_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Insert new like.
        $query = "INSERT INTO likes (video_id, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $video_id, $user_id);
        $stmt->execute();
    }
}
?>
