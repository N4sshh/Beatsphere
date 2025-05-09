<?php
class beatsphere
{
    private $db;
    public $model;

    function __construct()
    {
        try {
            $this->db = new mysqli('localhost', 'root', '', 'beatsphere');
        } catch (mysqli_sql_exception $e) {
            exit('❌ Database connection could not be established.');
        }

        require_once 'mode/SudlanKagGwaan.php';  
        $this->model = new SulodKagGwaanNiBeatsphere($this->db);
    }

    public function bastapageni()
    {
        $command = $_REQUEST['command'] ?? 'home';
        $artist_id = $_GET['artist_id'] ?? 0;
        $song_id = $_GET['song_id'] ?? 0;
        $id = $_GET['id'] ?? 0; // Generic ID parameter

        // Artist mapping
        $artist_map = [
            "bruno" => "bruno", "bruno-mars" => "bruno",
            "coldplay" => "coldplay", "ed-sheeran" => "ed-sheeran",
            "adele" => "adele", "lady-gaga" => "lady-gaga",
            "lany" => "lany"
        ];

        // Default artist IDs
        $artist_ids = [
            "bruno" => 1985, "coldplay" => 1977,
            "ed-sheeran" => 1991, "adele" => 1988,
            "lady-gaga" => 1986, "lany" => 1996
        ];

        switch ($command) {
            case 'home':
                include('PHP/homepage.php');
                break;
                
            case 'aboutus':
                include('PHP/AboutUs.php');
                break;
                
            case 'pop':
                include('PHP/pop.php');
                break;
                
            case 'beatspheredb':
                $search = $_GET['search'] ?? '';
                $results = $this->model->searchAllTables($search);
                include('PHP/beatspheredb.php');
                break;

            case (isset($artist_map[$command])):
                $this->handleArtistPage($artist_map, $command, $artist_id, $artist_ids);
                break;

            case 'suggestion_form':
                $artists = $this->model->getArtistList();
                include('PHP/suggestion_form.php');
                break;

            case 'viewSuggestions':
                $this->handleViewSuggestions($artist_id);
                break;

            // EDIT CASES
            case 'edit_artist':
                $artist = $this->model->getArtistById($id);
                if ($artist) {
                    include 'PHP/edit_artist.php';
                } else {
                    header("Location: ?command=beatspheredb&error=Artist+not+found");
                }
                break;

            case 'edit_song':
                $song = $this->model->getSongById($id);
                $artists = $this->model->getArtistList();
                if ($song) {
                    include 'PHP/edit_song.php';
                } else {
                    header("Location: ?command=beatspheredb&error=Song+not+found");
                }
                break;

            case 'edit_pop_song':
                $song = $this->model->getPopSongById($id);
                $artists = $this->model->getArtistList();
                if ($song) {
                    include 'PHP/edit_pop_song.php';
                } else {
                    header("Location: ?command=beatspheredb&error=Pop+song+not+found");
                }
                break;

            case 'edit_suggestion':
                $suggestion = $this->model->getSuggestionById($id);
                $artists = $this->model->getArtistList();
                if ($suggestion) {
                    include 'PHP/edit_suggestion.php';
                } else {
                    header("Location: ?command=beatspheredb&error=Suggestion+not+found");
                }
                break;

            // UPDATE CASES
            case 'update_artist':
                $this->handleUpdateArtist();
                break;

            case 'update_song':
                $this->handleUpdateSong();
                break;

            case 'update_pop_song':
                $this->handleUpdatePopSong();
                break;

            case 'update_suggestion':
                $this->handleUpdateSuggestion();
                break;

            // DELETE CASES
            case 'delete_artist':
                $this->handleDeleteArtist($id);
                break;

            case 'delete_song':
                $this->handleDeleteSong($id);
                break;

            case 'delete_pop_song':
                $this->handleDeletePopSong($id);
                break;

            case 'delete_suggestion':
                $this->handleDeleteSuggestion($id);
                break;

            case 'search':
                $this->handleSearch();
                break;

            default:
                include('PHP/homepage.php');
        }
    }

    // --- HELPER METHODS ---
    private function handleArtistPage($artist_map, $command, $artist_id, $artist_ids) {
        $file = $artist_map[$command] . ".php";
        $artist_path = "artists/" . $file;
        
        if (!file_exists($artist_path)) {
            die("Artist file not found: " . $artist_path);
        }

        $final_artist_id = $artist_id > 0 ? $artist_id : $artist_ids[$artist_map[$command]];
        
        if ($artist_id > 0) {
            include($artist_path);
        } else {
            header("Location: artists/" . $file . "?artist_id=" . $final_artist_id);
            exit();
        }
    }

    private function handleViewSuggestions($artist_id) {
        if ($artist_id > 0) {
            $suggestions = $this->model->getSongsForArtist($artist_id);
            include 'PHP/view_suggestion.php';
        } else {
            header("Location: ?command=pop");
            exit();
        }
    }

    private function handleUpdateArtist() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = $_POST['name'] ?? '';
            $bio = $_POST['bio'] ?? '';
            
            if ($id > 0 && !empty($name)) {
                $success = $this->model->updateArtist($id, $name, $bio);
                header("Location: ?command=beatspheredb&message=Artist+updated");
                exit();
            }
        }
        header("Location: ?command=beatspheredb&error=Invalid+input");
    }

    private function handleUpdateSong() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = $_POST['name'] ?? '';
            $video = $_POST['video'] ?? '';
            $artist_id = (int)$_POST['artist_id'];
            
            if ($id > 0 && !empty($name)) {
                $success = $this->model->updateSong($id, $name, $video, $artist_id);
                header("Location: ?command=beatspheredb&message=Song+updated");
                exit();
            }
        }
        header("Location: ?command=beatspheredb&error=Invalid+input");
    }

    private function handleUpdatePopSong() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $song_name = $_POST['song_name'] ?? '';
            $video_url = $_POST['video_url'] ?? '';
            $artist_id = (int)$_POST['artist_id'];
            
            if ($id > 0 && !empty($song_name)) {
                $success = $this->model->updatePopSong($id, $song_name, $video_url, $artist_id);
                header("Location: ?command=beatspheredb&message=Pop+song+updated");
                exit();
            }
        }
        header("Location: ?command=beatspheredb&error=Invalid+input");
    }

    private function handleUpdateSuggestion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $song_name = $_POST['song_name'] ?? '';
            $video_url = $_POST['video_url'] ?? '';
            $artist_id = (int)$_POST['artist_id'];
            $suggested_by = $_POST['suggested_by'] ?? '';
            
            if ($id > 0 && !empty($song_name)) {
                $success = $this->model->updateSuggestion($id, $song_name, $video_url, $artist_id, $suggested_by);
                header("Location: ?command=beatspheredb&message=Suggestion+updated");
                exit();
            }
        }
        header("Location: ?command=beatspheredb&error=Invalid+input");
    }

    private function handleDeleteArtist($id) {
        if ($id > 0) {
            $success = $this->model->deleteArtist($id);
            header("Location: ?command=beatspheredb&message=" . ($success ? "Artist+deleted" : "Error+deleting+artist"));
            exit();
        }
        header("Location: ?command=beatspheredb&error=Invalid+ID");
    }

    private function handleDeleteSong($id) {
        if ($id > 0) {
            $success = $this->model->deleteSong($id);
            header("Location: ?command=beatspheredb&message=" . ($success ? "Song+deleted" : "Error+deleting+song"));
            exit();
        }
        header("Location: ?command=beatspheredb&error=Invalid+ID");
    }

    private function handleDeletePopSong($id) {
        if ($id > 0) {
            $success = $this->model->deletePopSong($id);
            header("Location: ?command=beatspheredb&message=" . ($success ? "Pop+song+deleted" : "Error+deleting+pop+song"));
            exit();
        }
        header("Location: ?command=beatspheredb&error=Invalid+ID");
    }

    private function handleDeleteSuggestion($id) {
        if ($id > 0) {
            $success = $this->model->deleteSuggestion($id);
            header("Location: ?command=beatspheredb&message=" . ($success ? "Suggestion+deleted" : "Error+deleting+suggestion"));
            exit();
        }
        header("Location: ?command=beatspheredb&error=Invalid+ID");
    }

    private function handleSearch() {
        $search_term = $_GET['q'] ?? '';
        if (!empty($search_term)) {
            $results = $this->model->searchSongs($search_term);
            include('PHP/search_results.php');
        } else {
            $this->goBackToHome();
        }
    }

    public function goBackToHome() {
        header('Location: ?command=home');
        exit();
    }

    public function goBackToArtists() {
        header('Location: ?command=pop');
        exit();
    }
}