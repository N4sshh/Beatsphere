<?php $artist = $this->model->getArtistById($_GET['id']); ?>
<h2>Edit Artist</h2>
<form action="?command=update_artist" method="post">
    <input type="hidden" name="id" value="<?= $artist['id'] ?>">
    
    <div>
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($artist['name']) ?>" required>
    </div>
    
    <div>
        <label>Bio:</label>
        <textarea name="bio" required><?= htmlspecialchars($artist['bio']) ?></textarea>
    </div>
    
    <button type="submit">Save Changes</button>
    <a href="?command=beatspheredb">Cancel</a>
</form>