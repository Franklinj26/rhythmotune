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

// Obtener ID del álbum desde la URL
$album_id = $_GET['id'] ?? null;
if (!$album_id) {
    header("Location: ./bien.php");
    exit();
}

// Consulta para obtener información del álbum
$sql_album = "SELECT 
    a.id_album,
    a.nom_album,
    a.portada_album,
    a.año,
    ar.id_artista,
    ar.nom_artista,
    ar.foto_artista
FROM albums a
JOIN artistas ar ON a.id_artista = ar.id_artista
WHERE a.id_album = ?";

$stmt = mysqli_prepare($conn, $sql_album);
mysqli_stmt_bind_param($stmt, "i", $album_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$album = mysqli_fetch_assoc($result);

if (!$album) {
    header("Location: ./bien.php");
    exit();
}

// Consulta para canciones del álbum
$sql_canciones = "SELECT 
    c.id_cancion,
    c.nom_cancion AS title,
    c.ruta_audio AS audio,
    c.duracion,
    a.nom_album,
    a.nombre_directorio AS album_folder,
    a.portada_album AS cover,
    ar.nom_artista AS artist
FROM canciones c
JOIN albums a ON c.id_album = a.id_album
JOIN artistas ar ON a.id_artista = ar.id_artista
WHERE a.id_album = ?
ORDER BY c.nom_cancion";

$stmt_canciones = mysqli_prepare($conn, $sql_canciones);
mysqli_stmt_bind_param($stmt_canciones, "i", $album_id);
mysqli_stmt_execute($stmt_canciones);
$canciones = mysqli_fetch_all(mysqli_stmt_get_result($stmt_canciones), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($album['nom_album']); ?> - RhythmoTune</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <div class="menu">
        <div class="menu-content">
            <h1 class="logo">RhythmoTune</h1>
            <nav>
                <ul class="nav-list">
                    <li class="nav-item"><a href="bien.php">Home</a></li>
                    <li class="nav-item"><a href="./artistas.php">Artistas</a></li>
                    <li class="nav-item"><a href="playlists.php">Mis Playlists</a></li>
                    <li class="nav-item"><a href="reproducciones.php">Canciones Escuchadas</a></li>
                </ul>
            </nav>
        </div>
        <form method="POST" action="logout.php" class="logout-form">
            <button class="btn-logout">Cerrar sesión</button>
        </form>
    </div>

    <main id="main-content">
        <header class="main-header">
            <h2>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> 👋</h2>
            <input type="text" placeholder="Buscar canciones..." class="search-bar"/>
        </header>

        <section class="album-header">
            <div class="album-cover">
                <?php if (!empty($album['portada_album'])): ?>
                    <img src="../portada/albums/<?php echo htmlspecialchars($album['portada_album']); ?>" 
                         alt="<?php echo htmlspecialchars($album['nom_album']); ?>">
                <?php else: ?>
                    <img src="../iconos/album-placeholder.png" 
                         alt="Álbum sin portada">
                <?php endif; ?>
            </div>
            <div class="album-info">
                <h1><?php echo htmlspecialchars($album['nom_album']); ?></h1>
                <div class="artist-info" onclick="window.location.href='ver_artista.php?id=<?php echo $album['id_artista']; ?>'">
                    <?php if (!empty($album['foto_artista'])): ?>
                        <img src="../portada/artistas/<?php echo htmlspecialchars($album['foto_artista']); ?>" 
                            alt="<?php echo htmlspecialchars($album['nom_artista']); ?>">
                    <?php else: ?>
                        <img src="../iconos/artist-placeholder.png" 
                            alt="<?php echo htmlspecialchars($album['nom_artista']); ?>">
                    <?php endif; ?>
                    <span><?php echo htmlspecialchars($album['nom_artista']); ?></span>
                </div>
                <p class="album-year"><?php echo htmlspecialchars($album['año']); ?></p>
                <p class="songs-count"><?php echo count($canciones); ?> canciones</p>
                <button class="btn-play" onclick="playAlbum()">Reproducir álbum</button>
            </div>
        </section>

        <section class="music-section">
            <h2 class="section-title">Canciones</h2>
            <div class="songs-list">
                <?php foreach ($canciones as $index => $cancion): ?>
                <div class="song-item" 
                    onclick="playSongFromAlbum(<?php echo $index; ?>)">
                    <span class="track-number"><?php echo $index + 1; ?></span>
                    <div class="song-details">
                        <span class="song-title"><?php echo htmlspecialchars($cancion['title']); ?></span>
                        <span class="song-artist"><?php echo htmlspecialchars($cancion['artist']); ?></span>
                    </div>
                    <span class="song-duration"><?php echo htmlspecialchars($cancion['duracion']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <a href="bien.php" class="back-link">⬅️ Volver al inicio</a>
        </section>

        <div class="music-player" id="musicPlayer">
          <!-- REPRODUCTOR MUSICAL -->
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
// Variable global para almacenar las canciones del álbum
const albumSongs = [
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

// Función para reproducir canción específica del álbum
function playSongFromAlbum(index) {
    // Cargar todas las canciones del álbum
    songs = [...albumSongs];
    currentSongIndex = index;
    isPlaylistMode = true; // Activar modo playlist para permitir navegar entre canciones
    
    // Cargar y reproducir la canción seleccionada
    loadSong(songs[currentSongIndex]);
    
    // Si no está reproduciendo, iniciar reproducción
    if (!isPlaying) {
        togglePlay();
    }
}

// Función para reproducir todo el álbum
function playAlbum() {
    if (albumSongs.length > 0) {
        songs = [...albumSongs];
        currentSongIndex = 0;
        isPlaylistMode = true;
        loadAndPlaySong();
    } else {
        alert('No hay canciones en este álbum');
    }
}
</script>
    
    <style>
        /* Estilos adicionales para la página de álbum */
        .album-header {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            align-items: flex-end;
        }
        
        .album-cover img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .album-info h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .artist-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
            cursor: pointer;
        }
        
        .artist-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .album-year, .songs-count {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .songs-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .song-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 6px;
            background-color: var(--card-bg);
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .song-item:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .track-number {
            width: 30px;
            text-align: center;
            color: var(--text-secondary);
        }
        
        .song-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .song-title {
            font-weight: 500;
        }
        
        .song-artist {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }
        
        .song-duration {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        .btn-play {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.2s;
        }

        .btn-play:hover {
            background-color: #1ed760;
        }
    </style>
</body>
</html>

