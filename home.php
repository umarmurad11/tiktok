<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333333;
        }

        /* Header with Layers */
        .navbar {
            position: relative;
            padding: 1.5rem 1rem;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(90deg, #004aad, #00b8d4);
            clip-path: polygon(0 0, 100% 0, 100% 50%, 0 80%);
            z-index: -2;
        }

        .navbar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(90deg, #00796b, #004aad);
            clip-path: polygon(0 20%, 100% 0, 100% 100%, 0 100%);
            z-index: -2;
        }

        .navbar .brand {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .navbar .brand img {
            height: 60px;
            width: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 2px solid white;
        }

        .navbar .brand h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .navbar .brand p {
            margin: 0;
            font-size: 1.2rem;
            opacity: 0.8;
        }

        .logout-btn {
            position: absolute;
            right: 1rem;
            top: 1.5rem;
            background: transparent;
            color: white;
            border: 2px solid transparent;
            border-image: linear-gradient(90deg, #00796b, #004aad);
            border-image-slice: 1;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(90deg, rgba(0, 121, 107, 0.5), rgba(0, 74, 173, 0.5));
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .logout-btn:active {
            transform: translateY(0);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Main Container */
        .main-container {
            display: flex;
            margin-top: 20px;
        }

        /* Upload Section with Layers */
        .upload-section {
            flex: 0 0 30%;
            padding: 0;
            position: relative;
        }

        .upload-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: #004aad;
            clip-path: polygon(0 0, 100% 0, 100% 50%, 0 100%);
            z-index: -2;
        }

        .upload-section::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 50%;
            background: #00796b;
            clip-path: polygon(0 0, 100% 50%, 100% 100%, 0 100%);
            z-index: -2;
        }

        .upload-form {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            z-index: 1;
            position: relative;
        }

        .upload-form h3 {
            color: #004aad;
            font-weight: bold;
        }

        .upload-form .btn-primary {
            background-color: #00796b;
            border: none;
        }

        .upload-form .btn-primary:hover {
            background-color: #004aad;
        }

        /* Video Section */
        .video-section {
            flex: 1;
            padding: 20px;
            max-height: 80vh;
            overflow-y: scroll;
        }

        .video-card {
            border: 1px solid #e3e3e3;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .video-card video {
            width: 100%;
            border-radius: 10px;
        }

        .video-card .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="container">
            <div class="brand">
                <img src="images.png" alt="Logo">
                <h1>Welcome to the Video App</h1>
                <p>Your personalized video sharing platform</p>
            </div>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <div class="main-container container">
        <!-- Upload Section -->
        <div class="upload-section">
            <div class="upload-form">
                <h3 class="text-center mb-3">Upload Your Video</h3>
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="video" class="form-label">Select Video File</label>
                        <input type="file" class="form-control" id="video" name="video" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </form>
            </div>
        </div>

        <!-- Video Section -->
        <div class="video-section">
            <div id="videos" class="row gx-4 gy-4"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadVideos() {
                $.get("get_videos.php", function (data) {
                    $("#videos").html(data);
                });
            }

            loadVideos();

            $("#uploadForm").submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        loadVideos();
                        alert("Video uploaded successfully!");
                    }
                });
            });

            $(document).on("click", ".like-btn", function () {
                var videoId = $(this).data("id");
                $.post("like.php", { video_id: videoId }, function () {
                    loadVideos();
                });
            });

            $(document).on("submit", ".comment-form", function (e) {
                e.preventDefault();
                var videoId = $(this).data("id");
                var comment = $(this).find(".comment-input").val();
                $.post("comment.php", { video_id: videoId, comment: comment }, function () {
                    loadVideos();
                });
            });
        });
    </script> 
</body>
</html>
