<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video_id = $_POST['video_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id']; // Ensure user is logged in.

    if (!empty($comment)) {
        $query = "INSERT INTO comments (video_id, user_id, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $video_id, $user_id, $comment);
        $stmt->execute();
    }
}
?>
