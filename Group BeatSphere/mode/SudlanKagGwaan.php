<?php
class SulodKagGwaanNiBeatsphere
{
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    // SEARCH ALL TABLES METHOD
    public function searchAllTables($search_term) {
        $search_term = "%$search_term%";
        $data = [];
        
        // Search artists
        $stmt = $this->db->prepare("SELECT * FROM artists WHERE name LIKE ? OR bio LIKE ?");
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $data['artists'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        // Search songs
        $stmt = $this->db->prepare("SELECT s.*, a.name AS artist_name FROM songs s 
                                   JOIN artists a ON s.artist_id = a.id 
                                   WHERE s.name LIKE ? OR a.name LIKE ?");
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $data['songs'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        // Search pop songs
        $stmt = $this->db->prepare("SELECT s.*, a.name AS artist_name FROM songs_pop s 
                                   JOIN artists a ON s.artist_id = a.id 
                                   WHERE s.song_name LIKE ? OR a.name LIKE ?");
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $data['pop_songs'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        // Search suggestions
        $stmt = $this->db->prepare("SELECT s.*, a.name AS artist_name FROM suggestions s 
                                   JOIN artists a ON s.artist_id = a.id 
                                   WHERE s.song_name LIKE ? OR a.name LIKE ? OR s.suggested_by LIKE ?");
        $stmt->bind_param("sss", $search_term, $search_term, $search_term);
        $stmt->execute();
        $data['suggestions'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $data;
    }

    // ARTIST METHODS
    public function getArtistList() {
        $data = [];
        $query = "SELECT id, name FROM artists ORDER BY name ASC";
        
        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        } else {
            error_log('Database Error: ' . $this->db->error);
        }
        return $data;
    }

    public function getArtistById($artist_id) {
        $stmt = $this->db->prepare("SELECT * FROM artists WHERE id = ?");
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return null;
        }
        $stmt->bind_param("i", $artist_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $artist = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $artist;
    }

    public function updateArtist($id, $name, $bio) {
        $stmt = $this->db->prepare("UPDATE artists SET name = ?, bio = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $bio, $id);
        return $stmt->execute();
    }

    public function deleteArtist($id) {
        $stmt = $this->db->prepare("DELETE FROM artists WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // SONG METHODS
    public function getSongsForArtist($artist_id) {
        $data = [];

        // Fetch official songs
        $stmt = $this->db->prepare("SELECT id, song_name, video_url FROM songs_pop WHERE artist_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $artist_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $row['type'] = 'official';
                $data[] = $row;
            }
            $stmt->close();
        } else {
            error_log('Prepare failed (songs_pop): ' . $this->db->error);
        }

        // Fetch suggestions
        $stmt = $this->db->prepare("SELECT id, song_name, video_url, suggested_by FROM suggestions WHERE artist_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $artist_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $row['type'] = 'suggestion';
                $data[] = $row;
            }
            $stmt->close();
        } else {
            error_log('Prepare failed (suggestions): ' . $this->db->error);
        }

        return $data;
    }

    public function getSongById($song_id) {
        $stmt = $this->db->prepare("SELECT * FROM songs WHERE id = ?");
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->db->error);
            return null;
        }
        $stmt->bind_param("i", $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $song = $result->num_rows > 0 ? $result->fetch_assoc() : null;
        $stmt->close();
        return $song;
    }

    public function updateSong($id, $name, $video, $artist_id) {
        $stmt = $this->db->prepare("UPDATE songs SET name = ?, video = ?, artist_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $name, $video, $artist_id, $id);
        return $stmt->execute();
    }

    public function deleteSong($id) {
        $stmt = $this->db->prepare("DELETE FROM songs WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // POP SONG METHODS
    public function getPopSongById($id) {
        $stmt = $this->db->prepare("SELECT * FROM songs_pop WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updatePopSong($id, $song_name, $video_url, $artist_id) {
        $stmt = $this->db->prepare("UPDATE songs_pop SET song_name = ?, video_url = ?, artist_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $song_name, $video_url, $artist_id, $id);
        return $stmt->execute();
    }

    public function deletePopSong($id) {
        $stmt = $this->db->prepare("DELETE FROM songs_pop WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // SUGGESTION METHODS
    public function addSuggestion($song_name, $video_url, $artist_id, $suggested_by) {
        $stmt = $this->db->prepare("INSERT INTO suggestions (song_name, video_url, artist_id, suggested_by) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            error_log('Prepare failed (addSuggestion): ' . $this->db->error);
            return false;
        }
        $stmt->bind_param("ssis", $song_name, $video_url, $artist_id, $suggested_by);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }

    public function getSuggestionById($id) {
        $stmt = $this->db->prepare("SELECT * FROM suggestions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateSuggestion($id, $song_name, $video_url, $artist_id, $suggested_by) {
        $stmt = $this->db->prepare("UPDATE suggestions SET song_name = ?, video_url = ?, artist_id = ?, suggested_by = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $song_name, $video_url, $artist_id, $suggested_by, $id);
        return $stmt->execute();
    }

    public function deleteSuggestion($id) {
        $stmt = $this->db->prepare("DELETE FROM suggestions WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // SEARCH METHODS
    public function searchSongs($search_term) {
        $search_term = "%{$search_term}%";
        $data = [];

        $query = "SELECT s.id, s.song_name, s.video_url, a.id as artist_id, a.name as artist_name, 'official' as type 
                 FROM songs_pop s 
                 JOIN artists a ON s.artist_id = a.id 
                 WHERE s.song_name LIKE ? OR a.name LIKE ?
                 UNION
                 SELECT s.id, s.song_name, s.video_url, a.id as artist_id, a.name as artist_name, 'suggestion' as type 
                 FROM suggestions s 
                 JOIN artists a ON s.artist_id = a.id 
                 WHERE s.song_name LIKE ? OR a.name LIKE ?";

        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
        } else {
            error_log('Prepare failed (searchSongs): ' . $this->db->error);
        }

        return $data;
    }
}
?>