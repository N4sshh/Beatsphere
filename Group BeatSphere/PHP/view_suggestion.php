<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beatsphere";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all suggested songs with artist_id between 1 and 100
$suggested_sql = "SELECT * FROM suggestions WHERE artist_id BETWEEN 1 AND 100 ORDER BY suggested_at DESC";
$suggested_result = $conn->query($suggested_sql);

// Fetch artists details for those who have valid artist_id within the range
$artist_sql = "SELECT * FROM artists WHERE id BETWEEN 1 AND 100";
$artist_result = $conn->query($artist_sql);

// Mapping artist IDs to their details
$artists = [];
while ($artist = $artist_result->fetch_assoc()) {
    $artists[$artist['id']] = $artist;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggested Songs</title>
    <link rel="stylesheet" href="CSS/style.css"> <!-- Your styles here -->
</head>
<body>
    <header>
        <h1>Suggested Songs</h1>
    </header>

    <div class="main-container">
        <!-- Display songs with a dedicated artist (artist_id between 1 and 100) -->
        <h2>Songs by Artist</h2>
        <div class="artist-songs">
            <?php
            // Iterate over all suggested songs and group them by artist
            $current_artist_id = null;
            if ($suggested_result->num_rows > 0) {
                while ($song = $suggested_result->fetch_assoc()) {
                    // Only show songs with a valid artist_id between 1 and 100
                    if ($song['artist_id'] && $song['artist_id'] !== NULL && $song['artist_id'] >= 1 && $song['artist_id'] <= 100) {
                        // If it's a new artist, show artist details
                        if ($current_artist_id !== $song['artist_id']) {
                            // Show artist info
                            if (isset($artists[$song['artist_id']])) {
                                $artist = $artists[$song['artist_id']];
                                echo "<div class='artist-block'>";
                                echo "<h3 class='artist-name'>" . htmlspecialchars($artist['name']) . "</h3>";
                                echo "<p class='artist-bio'>" . htmlspecialchars($artist['bio']) . "</p>";
                                echo "<div class='bio-image'><img src='" . htmlspecialchars($artist['image_url']) . "' alt='" . htmlspecialchars($artist['name']) . "'></div>";
                                $current_artist_id = $song['artist_id'];  // Update to new artist
                            }
                        }

                        // Show the song with the YouTube embed
                        $video_id = getYouTubeVideoId($song['video_url']);
                        echo "<div class='song-item'>";
                        echo "<h4 class='song-name'>" . htmlspecialchars($song['song_name']) . "</h4>";
                        if ($video_id) {
                            echo "<iframe width='560' height='315' src='https://www.youtube.com/embed/{$video_id}' frameborder='0' allowfullscreen></iframe>";
                        } else {
                            echo "<p>⚠️ Invalid YouTube link.</p>";
                        }
                        echo "<p>Suggested by: " . htmlspecialchars($song['suggested_by']) . "</p>";
                        echo "</div>";
                    }
                }
            } else {
                echo "<p>No songs suggested by artists yet.</p>";
            }
            ?>
        </div>
    </div>

    <script>
        function filterArtists() {
            const filter = document.getElementById('searchInput').value.toLowerCase();
            const artistBlocks = document.querySelectorAll('.artist-block');

            artistBlocks.forEach(block => {
                const artistName = block.querySelector('.artist-name').textContent.toLowerCase();
                const songNames = Array.from(block.querySelectorAll('.song-name')).map(song => song.textContent.toLowerCase());
                const matchesArtist = artistName.includes(filter);
                const matchesSong = songNames.some(song => song.includes(filter));

                if (matchesArtist || matchesSong) {
                    block.style.display = '';
                } else {
                    block.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();

// Helper function to get YouTube Video ID from URL
function getYouTubeVideoId($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    return isset($params['v']) ? $params['v'] : substr(parse_url($url, PHP_URL_PATH), 1);
}
?>
