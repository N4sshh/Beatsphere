<?php 
$song = $this->model->getPopSongById($_GET['id']);
$artists = $this->model->getArtistList();
?>
<h2>Edit Pop Song</h2>
<form action="?command=update_pop_song" method="post">
    <input type="hidden" name="id" value="<?= $song['id'] ?>">
    
    <div>
        <label>Song Name:</label>
        <input type="text" name="song_name" value="<?= htmlspecialchars($song['song_name']) ?>" required>
    </div>
    
    <div>
        <label>Video URL:</label>
        <input type="text" name="video_url" value="<?= htmlspecialchars($song['video_url']) ?>">
    </div>
    
    <div>
        <label>Artist:</label>
        <select name="artist_id" required>
            <?php foreach ($artists as $artist): ?>
            <option value="<?= $artist['id'] ?>" <?= $artist['id'] == $song['artist_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($artist['name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit">Save Changes</button>
    <a href="?command=beatspheredb">Cancel</a>
</form>