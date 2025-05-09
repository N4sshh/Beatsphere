<?php
// Database connection
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

// Fetch both official and suggested artists
$sql = "SELECT id, name, image_url, bio, 'official' AS type FROM artists
        UNION 
        SELECT id, name, image_url, bio, 'suggested' AS type FROM suggested_artists";

$result = $conn->query($sql);

$artists = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artists[] = [
            'id' => htmlspecialchars($row['id']),
            'name' => htmlspecialchars($row['name']),
            'image' => htmlspecialchars($row['image_url']),
            'bio' => htmlspecialchars($row['bio']),
            'type' => $row['type'] // Distinguish official vs. suggested artists
        ];
    }
} else {
    $artists = []; // Ensure the variable exists
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop Artist Portfolio</title>
    <link rel="stylesheet" href="CSS/pop.css">
</head>
<body>

    <div class="main-container">
        <h2>Explore Top Songs by Famous Artists</h2>
        <div class="artist-portfolio">
            <?php if (!empty($artists)): ?>
                <?php foreach ($artists as $artist): ?>
                    <div class="artist <?php echo $artist['type']; ?>" id="<?php echo $artist['id']; ?>">
                        <img src="<?php echo $artist['image']; ?>" alt="<?php echo $artist['name']; ?>" class="artist-photo">
                        <h3><?php echo $artist['name']; ?></h3>
                        <p class="artist-bio"><?php echo $artist['bio']; ?></p>
                        
                        <?php if ($artist['type'] === 'suggested'): ?>
                            <p class="suggested-label">(User Suggested)</p>
                            <button class="view-songs">
                                <a href="?command=viewSuggestions&artist_id=<?php echo $artist['id']; ?>&type=suggested">View Suggested Songs</a>
                            </button>
                        <?php else: ?>
                            <button class="view-songs">
                                <a href="?command=<?php echo strtolower(str_replace(' ', '-', $artist['name'])); ?>">View Top Songs</a>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No artists found in the database.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
