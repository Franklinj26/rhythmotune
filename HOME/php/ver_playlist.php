<?php
// Activar visualización de errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../../altausuario.html");
  exit();
}

require_once __DIR__ . '/../../conexion.php';
$usuario_id = $_SESSION['usuario_id'];

// Validar ID de playlist
if (!isset($_GET['id'])) {
  header("Location: playlists.php");
  exit();
}

$playlist_id = intval($_GET['id']);

// Obtener información de la playlist
$sql_playlist = "SELECT p.id_playlist, p.nom_playlist, p.f_creacion, 
                 COUNT(cp.id_cancion) AS num_canciones
                 FROM playlists p
                 LEFT JOIN canciones_playlists cp ON p.id_playlist = cp.id_playlist
                 WHERE p.id_playlist = ? AND p.id_usu = ?
                 GROUP BY p.id_playlist";
$stmt_playlist = mysqli_prepare($conn, $sql_playlist);
mysqli_stmt_bind_param($stmt_playlist, "ii", $playlist_id, $usuario_id);
mysqli_stmt_execute($stmt_playlist);
$playlist = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_playlist));

if (!$playlist) {
  header("Location: playlists.php");
  exit();
}

// Obtener canciones de la playlist
// En ver_playlist.php, cambia la consulta de canciones:
$sql_canciones = "SELECT c.id_cancion, c.nom_cancion AS title, c.duracion, c.ruta_audio AS audio,
                  a.nom_album, a.portada_album AS cover, 
                  ar.nom_artista AS artist, a.nombre_directorio AS album_folder
                  FROM canciones c
                  JOIN canciones_playlists cp ON c.id_cancion = cp.id_cancion
                  JOIN albums a ON c.id_album = a.id_album
                  JOIN artistas ar ON a.id_artista = ar.id_artista
                  WHERE cp.id_playlist = ?
                  ORDER BY cp.id_cancion DESC";
$stmt_canciones = mysqli_prepare($conn, $sql_canciones);
mysqli_stmt_bind_param($stmt_canciones, "i", $playlist_id);
mysqli_stmt_execute($stmt_canciones);
$canciones = mysqli_fetch_all(mysqli_stmt_get_result($stmt_canciones), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($playlist['nom_playlist']); ?> - RhythmoTune</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <div class="menu">
        <div class="menu-content">
            <h1 class="logo">RhythmoTune</h1>
            <nav>
                <ul class="nav-list">
                    <li class="nav-item"><a href="./bien.php">Home</a></li>
                    <li class="nav-item"><a href="./artistas.php">Artistas</a></li>
                    <li class="nav-item"><a href="./playlists.php">Mis Playlists</a></li>
                    <li class="nav-item"><a href="./reproducciones.php">Canciones Escuchadas</a></li>
                </ul>
            </nav>
        </div>
        <form method="POST" action="logout.php" class="logout-form">
            <button class="btn-logout">Cerrar sesión</button>
        </form>
    </div>

    <main id="main-content">
        <header class="main-header">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?> 👋</h2>
        </header>

        <section class="playlist-section">
            <div class="playlist-header">
                <div class="playlist-cover">
                    🎵
                </div>
                <div class="playlist-info">
                    <p class="playlist-meta">PLAYLIST</p>
                    <h1 class="playlist-title"><?php echo htmlspecialchars($playlist['nom_playlist']); ?></h1>
                    <p class="playlist-meta">
                        Creada por <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?> • 
                        <?php echo $playlist['num_canciones']; ?> canciones
                    </p>
                    <div class="playlist-actions">
                        <button class="btn-play" onclick="playPlaylist()">Reproducir</button>
                        <a href="añadir_canciones.php?id=<?php echo $playlist_id; ?>" class="btn-play">➕ Añadir canciones</a>

                    </div>
                </div>
            </div>

            <div class="songs-list">
                <?php if (!empty($canciones)): ?>
                    <?php foreach ($canciones as $index => $cancion): ?>
                        <div class="song-item" onclick="playPlaylistSong(<?php echo $index; ?>)">
                            <span class="song-number"><?php echo $index + 1; ?></span>
                            <?php if (!empty($cancion['cover'])): ?>
                                <img src="../portada/albums/<?php echo htmlspecialchars($cancion['cover']); ?>" 
                                     alt="Portada" class="song-cover">
                            <?php else: ?>
                                <img src="../iconos/album-placeholder.png" 
                                     alt="Sin portada" class="song-cover">
                            <?php endif; ?>
                            <div class="song-details">
                                <div class="song-title"><?php echo htmlspecialchars($cancion['title']); ?></div>
                                <div class="song-artist"><?php echo htmlspecialchars($cancion['artist']); ?></div>
                            </div>
                            <span class="song-duration"><?php echo htmlspecialchars($cancion['duracion']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>No hay canciones en esta playlist</p>
                        <a href="añadir_canciones.php?id=<?php echo $playlist_id; ?>" class="btn-play">➕ Añadir canciones</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
          <!-- REPRODUCTOR MUSICAL -->
          <div class="music-player" id="musicPlayer">
            <div class="player-content">
                <div class="song-info">
                    <img id="currentSongCover" src="../iconos/music-placeholder.png" alt="Portada">
                    <div>
                        <h3 id="currentSongTitle">No hay canción seleccionada</h3>
                        <p id="currentSongArtist">Artista desconocido</p>
                    </div>
                </div>
                
                <div class="player-controls">
                    <audio id="audioPlayer"></audio>
                    <div class="controls-buttons">
                        <button class="control-btn" onclick="previousSong()">⏮</button>
                        <button class="control-btn" onclick="togglePlay()" id="playBtn">▶</button>
                        <button class="control-btn" onclick="nextSong()">⏭</button>
                    </div>
                    <div class="progress-container">
                        <span id="currentTime">0:00</span>
                        <input type="range" id="songProgress" value="0" class="progress-bar">
                        <span id="duration">0:00</span>
                    </div>
                </div>
                
                <div class="volume-control">
                    <span class="volume-icon">🔊</span>
                    <input type="range" id="volumeSlider" min="0" max="1" step="0.01" value="0.7">
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <hr>
            <div class="footer-grid">
                <div class="footer-logo">
                    <a href="../php/bien.php">
                        <img src="../iconos/RHYTMO6.jpg" alt="RhythmoTune Logo">
                    </a>
                </div>

                <div class="footer-links">
                    <ul>
                        <li><a href="../html/acerca_de.html" target="_blank">Acerca de</a></li>
                        <li><a href="../html/politica_de_privacidad.html">Política de privacidad</a></li>
                        <li><a href="../html/aviso_legal.html">Aviso legal</a></li>
                        <li><a href="../html/contacto.html">Contacto</a></li>
                        <!--<li><a href="#">Cookies</a></li>-->
                    </ul>
                </div>

                <div class="social-links">
                    <a href="https://www.instagram.com/" target="_blank"><img src="../iconos/ig.png" alt="Instagram"></a>
                    <a href="https://www.x.com/" target="_blank"><img src="../iconos/x.png" alt="Twitter/X"></a>
                    <a href="https://www.facebook.com/" target="_blank"><img src="../iconos/Facebook.png" alt="Facebook"></a>
                    <a href="https://www.linkedin.com/" target="_blank"><img src="../iconos/linkedin.jpg" alt="LinkedIn"></a>
                </div>
            </div>
            
            <div class="copyright">
                <span>© 2025 RhythmoTune - Salesianas</span>
            </div>
        </footer>
    </main>

    <script src="../js/script.js"></script>
    <script>
    // Variable global para las canciones de la playlist
    const playlistSongs = [
        <?php foreach ($canciones as $cancion): ?>
        {
            title: '<?php echo addslashes($cancion['title']); ?>',
            artist: '<?php echo addslashes($cancion['artist']); ?>',
            cover: '../portada/albums/<?php echo addslashes($cancion['cover']); ?>',
            audio: '../musica/<?php echo addslashes($cancion['album_folder']); ?>/<?php echo addslashes($cancion['audio']); ?>',
            duration: '<?php echo addslashes($cancion['duracion']); ?>',
            id: <?php echo $cancion['id_cancion']; ?>
        },
        <?php endforeach; ?>
    ];
    
    // Función para reproducir canción específica de la playlist
    function playPlaylistSong(index) {
        // Cargar todas las canciones de la playlist
        songs = [...playlistSongs];
        currentSongIndex = index;
        isPlaylistMode = true; // Activar modo playlist para permitir navegar entre canciones
        
        // Cargar y reproducir la canción seleccionada
        loadSong(songs[currentSongIndex]);
        
        // Si no está reproduciendo, iniciar reproducción
        if (!isPlaying) {
            togglePlay();
        }
    }

    // Función para reproducir toda la playlist
    function playPlaylist() {
        if (playlistSongs.length > 0) {
            songs = [...playlistSongs];
            currentSongIndex = 0;
            isPlaylistMode = true;
            loadAndPlaySong();
        } else {
            alert('No hay canciones para reproducir en esta playlist');
        }
    }
    </script>
</body>
</html>

