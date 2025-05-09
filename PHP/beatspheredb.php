<!DOCTYPE html>
<html>
<head>
    <title>BeatSphere Database Management</title>
    <link rel="stylesheet" href="CSS/db.css">
  
</head>
<body>

<!-- SEARCH FUNCTIONALITY -->
<form method="GET" action="">
    <input type="hidden" name="command" value="beatspheredb">
    <input type="text" name="search" class="search-box" placeholder="Search across all tables..." 
           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit">Search</button>
</form>

<h2>Artists</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Bio</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $db = new mysqli('localhost', 'root', '', 'beatsphere');
    if ($db->connect_error) die("Database connection failed: " . $db->connect_error);

    // SEARCH LOGIC
    $search = $_GET['search'] ?? '';
    $searchCondition = $search ? "WHERE name LIKE '%$search%' OR bio LIKE '%$search%'" : "";

    // ARTISTS TABLE
    $artists = $db->query("SELECT * FROM artists $searchCondition");
    while ($artist = $artists->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($artist['id']) . "</td>
                <td><a href='./PHP/artist_details.php?artist_id=" . $artist['id'] . "'>" . 
                   htmlspecialchars($artist['name']) . "</a></td>
                <td>" . htmlspecialchars(substr($artist['bio'], 0, 50)) . "...</td>
                <td class='action-links'>
                    <a href='?command=edit_artist&id=" . $artist['id'] . "'>Edit</a>
                    <a href='?command=delete_artist&id=" . $artist['id'] . "' 
                       onclick='return confirm(\"Delete this artist?\")'>Delete</a>
                </td>
              </tr>";
    }

    // SONGS TABLE (with search)
    $songSearch = $search ? "WHERE name LIKE '%$search%'" : "";
    echo "</tbody></table><h2>Songs</h2><table><thead><tr>
          <th>ID</th><th>Song Name</th><th>Artist ID</th><th>Video</th><th>Action</th></tr></thead><tbody>";
    
    $songs = $db->query("SELECT * FROM songs $songSearch");
    while ($song = $songs->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($song['id']) . "</td>
                <td>" . htmlspecialchars($song['name']) . "</td>
                <td>" . htmlspecialchars($song['artist_id']) . "</td>
                <td><a href='" . htmlspecialchars($song['video']) . "' target='_blank'>Watch</a></td>
                <td class='action-links'>
                    <a href='?command=edit_song&id=" . $song['id'] . "'>Edit</a>
                    <a href='?command=delete_song&id=" . $song['id'] . "' 
                       onclick='return confirm(\"Delete this song?\")'>Delete</a>
                </td>
              </tr>";
    }

    // POP SONGS TABLE
    $popSearch = $search ? "WHERE song_name LIKE '%$search%'" : "";
    echo "</tbody></table><h2>Pop Songs</h2><table><thead><tr>
          <th>ID</th><th>Artist ID</th><th>Song Name</th><th>Video</th><th>Action</th></tr></thead><tbody>";
    
    $popSongs = $db->query("SELECT * FROM songs_pop $popSearch");
    while ($popSong = $popSongs->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($popSong['id']) . "</td>
                <td>" . htmlspecialchars($popSong['artist_id']) . "</td>
                <td>" . htmlspecialchars($popSong['song_name']) . "</td>
                <td><a href='" . htmlspecialchars($popSong['video_url']) . "' target='_blank'>Watch</a></td>
                <td class='action-links'>
                    <a href='?command=edit_pop_song&id=" . $popSong['id'] . "'>Edit</a>
                    <a href='?command=delete_pop_song&id=" . $popSong['id'] . "' 
                       onclick='return confirm(\"Delete this pop song?\")'>Delete</a>
                </td>
              </tr>";
    }

    // SUGGESTED SONGS TABLE
    $suggestionSearch = $search ? "WHERE song_name LIKE '%$search%' OR suggested_by LIKE '%$search%'" : "";
    echo "</tbody></table><h2>Suggested Songs</h2><table><thead><tr>
          <th>ID</th><th>Song Name</th><th>Video</th><th>Suggested By</th><th>Artist ID</th><th>Action</th></tr></thead><tbody>";
    
    $suggestions = $db->query("SELECT * FROM suggestions $suggestionSearch");
    while ($suggestion = $suggestions->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($suggestion['id']) . "</td>
                <td>" . htmlspecialchars($suggestion['song_name']) . "</td>
                <td><a href='" . htmlspecialchars($suggestion['video_url']) . "' target='_blank'>Watch</a></td>
                <td>" . htmlspecialchars($suggestion['suggested_by']) . "</td>
                <td>" . htmlspecialchars($suggestion['artist_id']) . "</td>
                <td class='action-links'>
                    <a href='?command=edit_suggestion&id=" . $suggestion['id'] . "'>Edit</a>
                    <a href='?command=delete_suggestion&id=" . $suggestion['id'] . "' 
                       onclick='return confirm(\"Delete this suggestion?\")'>Delete</a>
                </td>
              </tr>";
    }

    $db->close();
    ?>
    </tbody>
</table>

</body>
</html>