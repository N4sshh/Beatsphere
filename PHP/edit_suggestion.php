<?php 
$suggestion = $this->model->getSuggestionById($_GET['id']);
$artists = $this->model->getArtistList();
?>
<h2>Edit Suggestion</h2>
<form action="?command=update_suggestion" method="post">
    <input type="hidden" name="id" value="<?= $suggestion['id'] ?>">
    
    <div>
        <label>Song Name:</label>
        <input type="text" name="song_name" value="<?= htmlspecialchars($suggestion['song_name']) ?>" required>
    </div>
    
    <div>
        <label>Video URL:</label>
        <input type="text" name="video_url" value="<?= htmlspecialchars($suggestion['video_url']) ?>">
    </div>
    
    <div>
        <label>Artist:</label>
        <select name="artist_id" required>
            <?php foreach ($artists as $artist): ?>
            <option value="<?= $artist['id'] ?>" <?= $artist['id'] == $suggestion['artist_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($artist['name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div>
        <label>Suggested By:</label>
        <input type="text" name="suggested_by" value="<?= htmlspecialchars($suggestion['suggested_by']) ?>">
    </div>
    
    <button type="submit">Save Changes</button>
    <a href="?command=beatspheredb">Cancel</a>
</form>