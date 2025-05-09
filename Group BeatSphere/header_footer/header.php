<style>
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background-color: #2c3e50;
    color: #ecf0f1;
    position: sticky;
    top: 0;
    z-index: 1000;
    width: 100%;
    box-sizing: border-box;
}

header h1 {
    font-size: 2rem;
    font-weight: bold;
    margin: 0 auto;
    text-align: center;
    flex-grow: 1;
}

header .artists-btn {
    background-color: #ecf0f1;
    color: #2c3e50;
    padding: 5px 15px;
    border-radius: 5px;
    font-size: 1rem;
    text-decoration: none;
    transition: 0.3s ease-in-out;
    order: -1;
}

header .artists-btn:hover {
    background-color: #2c3e50;
    color: #ecf0f1;
}

header .home-btn {
    background-color: #ecf0f1;
    color: #2c3e50;
    padding: 5px 15px;
    border-radius: 5px;
    font-size: 1rem;
    text-decoration: none;
    transition: 0.3s ease-in-out;
    order: 2;
}

header .home-btn:hover {
    background-color: #2c3e50;
    color: #ecf0f1;
}

footer {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 0.85rem;
    color: #ecf0f1;
    background-color: #34495e;
    width: 100%;
    padding: 10px 20px;
    box-sizing: border-box;
}

footer p {
    margin: 0;
    text-align: center;
}

    </style>
<header>
            <a href="/Group%20BeatSphere/?command=home" class="home-btn">Home</a>
            <a href="/Group%20BeatSphere/?command=pop" class="artists-btn">Artists</a>
            <h1>BeatSphere: Where Music Comes Alive</h1>
</header>

