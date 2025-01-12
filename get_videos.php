<?php
include 'config.php';

$query = "SELECT videos.id, videos.filename, videos.user_id, users.username, 
                 (SELECT COUNT(*) FROM likes WHERE likes.video_id = videos.id) AS like_count,
                 (SELECT GROUP_CONCAT(DISTINCT u.username SEPARATOR ', ') 
                  FROM likes l 
                  JOIN users u ON l.user_id = u.id 
                  WHERE l.video_id = videos.id) AS liked_by,
                 (SELECT GROUP_CONCAT(comment SEPARATOR '\n') 
                  FROM comments WHERE comments.video_id = videos.id) AS comments
          FROM videos 
          JOIN users ON videos.user_id = users.id
          ORDER BY videos.id DESC";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<div class="col-md-6 mb-4">
            <div class="video-card">
                <video src="uploads/' . htmlspecialchars($row['filename']) . '" controls class="w-100 mb-2"></video>
                <p>Uploaded by: ' . htmlspecialchars($row['username']) . '</p>
                <p>Likes: ' . $row['like_count'] . '</p>';
    if (!empty($row['liked_by'])) {
        echo '<p><strong>Liked by:</strong> ' . htmlspecialchars($row['liked_by']) . '</p>';
    }
    echo '  <button class="btn btn-primary like-btn" data-id="' . $row['id'] . '">Like</button>
                <form class="comment-form mt-2" data-id="' . $row['id'] . '">
                    <input type="text" class="form-control comment-input" placeholder="Add a comment" required>
                    <button type="submit" class="btn btn-secondary mt-2">Comment</button>
                </form>
                <pre>' . htmlspecialchars($row['comments']) . '</pre>
            </div>
          </div>';
}
?>
