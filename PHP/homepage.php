<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beatsphere";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch songs from the database
$sql = "SELECT * FROM songs";
$result = $conn->query($sql);

$playlist = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $playlist[] = [
            'name' => $row['name'],
            'video' => $row['video']
        ];
    }
} else {
    echo "No songs found in the database.";
}

// Default song to display
$selectedSong = $playlist[0] ?? ["name" => "No Song Available", "video" => ""];

// Check if a song is selected via query string
if (isset($_GET['song'])) {
    $songIndex = (int)$_GET['song'];
    if (isset($playlist[$songIndex])) {
        $selectedSong = $playlist[$songIndex];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeatSphere: Where Music Comes Alive</title>
    <link rel="stylesheet" href="CSS/homepage.css">
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <h2>Genres</h2>
            <ul>
                <li><a href="?command=pop">Pop</a></li>
                <li><a href="?command=aboutus">About Us</a></li>
                <li><a href="?command=beatspheredb">Database</a></li>
                <li><a href="?command=suggestion_form">Suggest a Song</a></li>
            </ul>
        </aside>
        <main class="content">
            <div class="videoBox">
                <video id="video-player" controls>
                    <source src="<?php echo htmlspecialchars($selectedSong['video']); ?>" type="video/mp4">
                    Your browser does not support the video element.
                </video>
            </div>
            <div class="playlist">
                <h2>Your History Playlist</h2>
                <ul>
                    <?php foreach ($playlist as $index => $song): ?>
                        <li>
                            <a href="?song=<?php echo $index; ?>"> <?php echo htmlspecialchars($song['name']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
