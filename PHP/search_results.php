<h2>Search Results</h2>

<?php if (!empty($results)): ?>
<ul>
    <?php foreach ($results as $song): ?>
    <li>
        <?= htmlspecialchars($song['song_name']) ?> - <?= htmlspecialchars($song['artist_name']) ?>
        <a href="?command=edit&song_id=<?= $song['song_id'] ?>">Edit</a>
        <a href="?command=delete&song_id=<?= $song['song_id'] ?>&artist_id=<?= $song['artist_id'] ?>" 
           onclick="return confirm('Delete this song?')">Delete</a>
    </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<p>No results found.</p>
<?php endif; ?>

<a href="?command=home">Back to Home</a>