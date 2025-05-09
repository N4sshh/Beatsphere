<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggest a Song or Artist - BeatSphere</title>
    <link rel="stylesheet" href="CSS/suggestionform.css">
    <style>
        input[type="file"] {
            display: none;
        }
        .custom-file-button {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #197909;    
            color: #fff;
            padding: 10px 20px;        
        }
        #previewImage {
            max-width: 300px;
            max-height: 300px;
            display: none;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
        .form-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
        }
    </style>
    <script>
        function toggleForm() {
            let actionType = document.querySelector('input[name="action_type"]:checked').value;
            document.getElementById('new_artist_section').style.display = actionType === 'new_artist' ? 'block' : 'none';
            document.getElementById('add_song_section').style.display = actionType === 'add_song' ? 'block' : 'none';
        }

        function imagePreview(event) {
            if(event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("previewImage");
                preview.src = src;      
                preview.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Suggest a Song or Artist</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <div class="alert success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form action="index.php?command=suggestion_form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="radio-label">
                    <input type="radio" name="action_type" value="new_artist" onchange="toggleForm()">
                    Add a New Artist and First Song
                </label>
                <label class="radio-label">
                    <input type="radio" name="action_type" value="add_song" onchange="toggleForm()">
                    Add a Song to an Existing Artist
                </label>
            </div>

            <div id="new_artist_section" class="form-section" style="display: none;">
                <div class="form-group">
                    <label for="artist_name">Artist Name:</label>
                    <input type="text" id="artist_name" name="artist_name" class="form-control" value="<?php echo htmlspecialchars($_POST['artist_name'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="bio">Artist Bio:</label>
                    <textarea id="bio" name="bio" class="form-control" rows="3"><?php echo htmlspecialchars($_POST['bio'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Artist Image:</label>
                    <label for="artist_image" class="custom-file-button">Choose Image</label>
                    <input type="file" name="artist_image" id="artist_image" onchange="imagePreview(event)" accept="image/*">
                    <img id="previewImage" alt="Image Preview">
                </div>

                <div class="form-group">
                    <label for="new_artist_song_name">First Song Name:</label>
                    <input type="text" id="new_artist_song_name" name="new_artist_song_name" class="form-control" value="<?php echo htmlspecialchars($_POST['new_artist_song_name'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="new_artist_video_url">YouTube Link or MP4 URL:</label>
                    <input type="url" id="new_artist_video_url" name="new_artist_video_url" class="form-control" value="<?php echo htmlspecialchars($_POST['new_artist_video_url'] ?? ''); ?>">
                </div>
            </div>

            <div id="add_song_section" class="form-section" style="display: none;">
    <div class="form-group">
        <label for="artist_id">Select Artist:</label>
        <select id="artist_id" name="artist_id" class="form-control" required>
            <option value="">-- Select an Artist --</option>
            <?php if (!empty($artists)): ?>
                <?php foreach ($artists as $artist): ?>
                    <option value="<?= htmlspecialchars($artist['id']) ?>"
                        <?= (isset($_POST['artist_id']) && $_POST['artist_id'] == $artist['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($artist['name']) ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="" disabled>No artists available</option>
            <?php endif; ?>
        </select>
    </div>

                <div class="form-group">
                    <label for="song_name">Song Name:</label>
                    <input type="text" id="song_name" name="song_name" class="form-control" value="<?php echo htmlspecialchars($_POST['song_name'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="video_url">YouTube Link:</label>
                    <input type="url" id="video_url" name="video_url" class="form-control" value="<?php echo htmlspecialchars($_POST['video_url'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="suggested_by">Your Name (optional):</label>
                <input type="text" id="suggested_by" name="suggested_by" class="form-control" value="<?php echo htmlspecialchars($_POST['suggested_by'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <button type="submit" class="submit-button">Submit</button>
                <button type="reset" class="reset-button">Reset</button>
            </div>
        </form>
    </div>
</body>
</html>