<?php
function getYouTubeVideoId($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    return $params['v'] ?? substr(parse_url($url, PHP_URL_PATH), 1);
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beatsphere";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get artist ID dynamically
$artist_id = isset($_GET['artist_id']) ? intval($_GET['artist_id']) : 0;

// Fetch artist details
$artist_sql = "SELECT * FROM artists WHERE id = ?";
$stmt = $conn->prepare($artist_sql);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$artist_result = $stmt->get_result();
$artist = $artist_result->fetch_assoc();

if (!$artist) {
    die("Artist not found.");
}

// Fetch official songs from songs_pop
$songs_sql = "SELECT song_name, video_url FROM songs_pop WHERE artist_id = ?";
$stmt = $conn->prepare($songs_sql);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$songs_result = $stmt->get_result();

// Fetch user-suggested songs from suggestions
$suggested_sql = "SELECT song_name, video_url, suggested_by FROM suggestions WHERE artist_id = ?";
$stmt = $conn->prepare($suggested_sql);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$suggested_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($artist['name']); ?> Music Videos</title>
    <link rel="stylesheet" href="../CSS/bruno.css">
</head>
<body class="bruno-mars-theme">
<?php include_once('../header_footer/header.php'); ?>

    <header class="navbar">
        <h1 class="logo"><?php echo htmlspecialchars($artist['name']); ?> Music Videos</h1>
    </header>

    <div class="main-container">
        <h2>About <?php echo htmlspecialchars($artist['name']); ?></h2>
        
        <div class="bio-content">
            <img src="<?php echo htmlspecialchars($artist['image_url']); ?>" alt="<?php echo htmlspecialchars($artist['name']); ?>" class="bio-image">
            <p class="artist-bio"><?php echo htmlspecialchars($artist['bio']); ?></p>
        </div>

        <h2>Top Songs:</h2>
        <div class="video-grid">
            <?php if ($songs_result->num_rows > 0): ?>
                <?php while ($song = $songs_result->fetch_assoc()): ?>
                    <div class="video-item">
                        <?php 
                        $video_url = $song['video_url'];
                        $is_youtube = strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false;
                        ?>
                        <?php if ($is_youtube): ?>
                            <iframe width="100%" height="315" 
                                    src="https://www.youtube.com/embed/<?php echo getYouTubeVideoId($video_url); ?>" 
                                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                            </iframe>
                        <?php else: ?>
                            <video controls width="100%" height="315">
                                <source src="<?php echo htmlspecialchars($video_url); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                        <h4><?php echo htmlspecialchars($song['song_name']); ?></h4>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No songs available for <?php echo htmlspecialchars($artist['name']); ?>.</p>
            <?php endif; ?>
        </div>

        <!-- Suggested Videos Section -->
        <div class="video-grid">
            <?php if ($suggested_result->num_rows > 0): ?>
                <?php while ($suggested = $suggested_result->fetch_assoc()): ?>
                    <div class="video-item">
                        <?php 
                        $video_url = $suggested['video_url'];
                        $is_youtube = strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false;
                        ?>
                        <?php if ($is_youtube): ?>
                            <iframe width="100%" height="315" 
                                    src="https://www.youtube.com/embed/<?php echo getYouTubeVideoId($video_url); ?>" 
                                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                            </iframe>
                        <?php else: ?>
                            <video controls width="100%" height="315">
                                <source src="<?php echo htmlspecialchars($video_url); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                        <h4><?php echo htmlspecialchars($suggested['song_name']); ?></h4>
                        <p>Suggested by: <?php echo htmlspecialchars($suggested['suggested_by']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No user-suggested songs yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php include_once('../header_footer/footer.php'); ?>

<?php 
$stmt->close();
$conn->close();
?>
