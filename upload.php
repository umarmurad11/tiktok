<?php
include 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $video = $_FILES['video'];
        $ext = pathinfo($video['name'], PATHINFO_EXTENSION);
        $allowed_ext = ['mp4', 'mov', 'avi', 'mkv'];

        if (!in_array(strtolower($ext), $allowed_ext)) {
            echo "Invalid file type.";
            exit();
        }

        $filename = uniqid("vid_", true) . "." . $ext;
        $upload_path = __DIR__ . "/uploads/" . $filename;

        if (move_uploaded_file($video['tmp_name'], $upload_path)) {
            $query = "INSERT INTO videos (filename, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $filename, $user_id);

            if ($stmt->execute()) {
                echo "Video uploaded successfully.";
            } else {
                echo "Database error: " . $stmt->error;
            }
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No file uploaded or file error.";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
