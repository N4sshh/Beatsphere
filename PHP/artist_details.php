<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'beatsphere');
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Get artist ID from URL
$artist_id = isset($_GET['artist_id']) ? intval($_GET['artist_id']) : 0;

// Fetch artist data
$query = $db->prepare("SELECT * FROM artists WHERE id = ?");
$query->bind_param("i", $artist_id);
$query->execute();
$result = $query->get_result();
$artist = $result->fetch_assoc();

include '../header_footer/header.php'; // Include header
?>
    <link rel="stylesheet" href="CSS/artist_details.css">

<div class="main-container">
    <div class="details-container">
        <?php if ($artist): ?>
            <h2>Artist Details</h2>
            <p><strong>ID:</strong> <?php echo htmlspecialchars($artist['id']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($artist['name']); ?></p>
            <p><strong>Bio:</strong> <?php echo htmlspecialchars($artist['bio']); ?></p>

            <h3>Songs</h3>
            <ul>
                <?php
                // Fetch songs by this artist
                $songs_query = $db->prepare("SELECT * FROM songs_pop WHERE artist_id = ?");
                $songs_query->bind_param("i", $artist_id);
                $songs_query->execute();
                $songs_result = $songs_query->get_result();

                if ($songs_result->num_rows > 0) {
                    while ($song = $songs_result->fetch_assoc()) {
                        echo "<li>" . htmlspecialchars($song['song_name']) . " - ";
                        echo "<a href='" . htmlspecialchars($song['video_url']) . "' target='_blank'>Watch Video</a></li>";
                    }
                } else {
                    echo "<p>No songs found for this artist.</p>";
                }
                ?>
            </ul>
        <?php else: ?>
            <p>Artist not found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
include '../header_footer/footer.php'; // Include footer
$db->close();
?>
