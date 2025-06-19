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

// Verificar si hay una búsqueda
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Consulta para obtener las canciones más populares (o resultados de búsqueda)
if (!empty($searchQuery)) {
    // Búsqueda de canciones
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
    WHERE c.nom_cancion LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'
    OR ar.nom_artista LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'
    OR a.nom_album LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'
    ORDER BY c.reproducciones DESC
    LIMIT 20";
    
    // Búsqueda de artistas
    $sql_artistas = "SELECT 
        id_artista,
        nom_artista,
        foto_artista
    FROM artistas
    WHERE nom_artista LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'
    ORDER BY nom_artista ASC
    LIMIT 6";
    
    // Búsqueda de álbumes
    $sql_albumes = "SELECT 
        a.id_album,
        a.nom_album,
        a.portada_album,
        ar.nom_artista
    FROM albums a
    JOIN artistas ar ON a.id_artista = ar.id_artista
    WHERE a.nom_album LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'
    OR ar.nom_artista LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'
    ORDER BY a.año DESC
    LIMIT 10";
} else {
    // Consultas normales (sin búsqueda)
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
    ORDER BY c.reproducciones DESC
    LIMIT 5";

    $sql_artistas = "SELECT 
        id_artista,
        nom_artista,
        foto_artista
    FROM artistas
    ORDER BY nom_artista ASC
    LIMIT 6";

    $sql_albumes = "SELECT 
        a.id_album,
        a.nom_album,
        a.portada_album,
        ar.nom_artista
    FROM albums a
    JOIN artistas ar ON a.id_artista = ar.id_artista
    ORDER BY a.año DESC
    LIMIT 10";
}

$result_canciones = mysqli_query($conn, $sql_canciones);
$canciones = mysqli_fetch_all($result_canciones, MYSQLI_ASSOC);

$result_artistas = mysqli_query($conn, $sql_artistas);
$artistas = mysqli_fetch_all($result_artistas, MYSQLI_ASSOC);

$result_albumes = mysqli_query($conn, $sql_albumes);
$albumes = mysqli_fetch_all($result_albumes, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RhythmoTune - Reproductor Musical</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <div class="menu">
        <div class="menu-content">
            <h1 class="logo">RhythmoTune</h1>
            <nav>
                <ul class="nav-list">
                    <a href="https://www.instagram.com/rhythmotune/" target="_blank"><img src="../iconos/1.png" alt="Instagram"></a>
                    <a href="https://x.com/rhythmotun28714" target="_blank"><img src="../iconos/3.png" alt="Twitter/X"></a>
                    <a href="https://www.facebook.com/profile.php?id=61577711155281" target="_blank"><img src="../iconos/2.png" alt="Facebook"></a>
                    <a href="https://www.linkedin.com/in/rhythmo-tune-7905a2370/" target="_blank"><img src="../iconos/4.png" alt="LinkedIn"></a>
            </nav>
        </div>
        <form method="POST" action="logout.php" class="logout-form">
            <button class="btn-logout">Cerrar sesión</button>
        </form>
    </div>

    <main id="main-content">
    <header class="main-header">
    <h2>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> 👋</h2>
    <form method="GET" action="bien.php" class="search-form">
        <input type="text" name="query" placeholder="Buscador" 
               class="search-bar" id="searchInput" value="<?php echo isset($searchQuery) ? htmlspecialchars($searchQuery) : ''; ?>"/>
        <button type="submit" class="search-button">Buscar</button>
    </form>
</header>
<!-- Canciones -->
<section class="music-section">
    <h2 class="section-title">
        <?php echo !empty($searchQuery) ? "Resultados de canciones para: " . htmlspecialchars($searchQuery) : "Canciones populares"; ?>
    </h2>
    <div class="music-grid" id="songsGrid">
        <?php if (!empty($canciones)): ?>
            <?php foreach ($canciones as $cancion): ?>
        <div class="music-card" 
             onclick="playSongFromCard({
                 title: '<?php echo htmlspecialchars($cancion['title']); ?>',
                 artist: '<?php echo htmlspecialchars($cancion['artist']); ?>',
                 cover: '../portada/albums/<?php echo htmlspecialchars($cancion['cover']); ?>',
                 audio: '../musica/<?php echo htmlspecialchars($cancion['album_folder'] ?? $cancion['nom_album']); ?>/<?php echo htmlspecialchars($cancion['audio']); ?>',
                 duration: '<?php echo htmlspecialchars($cancion['duracion']); ?>',
                 id: <?php echo $cancion['id_cancion']; ?>
             })">
            <?php if (!empty($cancion['cover'])): ?>
                <img src="../portada/albums/<?php echo htmlspecialchars($cancion['cover']); ?>" 
                     alt="Portada de <?php echo htmlspecialchars($cancion['nom_album']); ?>">
            <?php else: ?>
                <img src="../iconos/album-placeholder.png" 
                     alt="Álbum sin portada">
            <?php endif; ?>
            <div class="song-info">
                <span class="song-title"><?php echo htmlspecialchars($cancion['title']); ?></span>
                <span class="song-artist"><?php echo htmlspecialchars($cancion['artist']); ?></span>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="no-results">No se encontraron canciones que coincidan con tu búsqueda.</p>
        <?php endif; ?>
    </div>
</section>
<!-- Artistas -->
<section class="music-section">
    <h2 class="section-title">
        <?php echo !empty($searchQuery) ? "Resultados de artistas para: " . htmlspecialchars($searchQuery) : "Artistas populares"; ?>
    </h2>
    <div class="artists-grid" id="artistsGrid">
        <?php if (!empty($artistas)): ?>
            <?php foreach ($artistas as $artista): ?>
        <div class="artist-card" 
             onclick="window.location.href='ver_artista.php?id_artista=<?php echo $artista['id_artista']; ?>'">
            <?php if (!empty($artista['foto_artista'])): ?>
                <img src="../portada/artistas/<?php echo htmlspecialchars($artista['foto_artista']); ?>" 
                     alt="<?php echo htmlspecialchars($artista['nom_artista']); ?>">
            <?php else: ?>
                <img src="../iconos/artist-placeholder.png" 
                     alt="<?php echo htmlspecialchars($artista['nom_artista']); ?>">
            <?php endif; ?>
            <span><?php echo htmlspecialchars($artista['nom_artista']); ?></span>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="no-results">No se encontraron artistas que coincidan con tu búsqueda.</p>
        <?php endif; ?>
    </div>
</section>
<!-- Álbumes -->
<section class="music-section">
    <h2 class="section-title">
        <?php echo !empty($searchQuery) ? "Resultados de álbumes para: " . htmlspecialchars($searchQuery) : "Álbumes populares"; ?>
    </h2>
    <div class="albums-grid" id="albumsGrid">
        <?php if (!empty($albumes)): ?>
            <?php foreach ($albumes as $album): ?>
        <div class="album-card"
             onclick="window.location.href='ver_album.php?id=<?php echo $album['id_album']; ?>'">
            <?php if (!empty($album['portada_album'])): ?>
                <img src="../portada/albums/<?php echo htmlspecialchars($album['portada_album']); ?>" 
                     alt="<?php echo htmlspecialchars($album['nom_album']); ?>">
            <?php else: ?>
                <img src="../iconos/album-placeholder.png" 
                     alt="<?php echo htmlspecialchars($album['nom_album']); ?>">
            <?php endif; ?>
            <div class="album-info">
                <span class="album-title"><?php echo htmlspecialchars($album['nom_album']); ?></span>
                <span class="album-artist"><?php echo htmlspecialchars($album['nom_artista']); ?></span>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="no-results">No se encontraron álbumes que coincidan con tu búsqueda.</p>
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
    <script>
        // Función para búsqueda en tiempo real
        function searchSongs() {
            const input = document.getElementById('musicSearch');
            const filter = input.value.toUpperCase();
            const grid = document.getElementById('musicGrid');
            const songs = grid.getElementsByClassName('music-link');
            
            for (let i = 0; i < songs.length; i++) {
                const name = songs[i].querySelector('span').textContent.toUpperCase();
                if (name.includes(filter)) {
                    songs[i].style.display = "";
                } else {
                    songs[i].style.display = "none";
                }
            }
        }
        
        // Activar búsqueda al escribir
        document.getElementById('musicSearch').addEventListener('keyup', searchSongs);
    </script>
    <script>
    // Variable global para almacenar todas las canciones disponibles
    const allSongs = [
        <?php foreach ($canciones as $cancion): ?>
        {
            title: '<?php echo addslashes($cancion['title']); ?>',
            artist: '<?php echo addslashes($cancion['artist']); ?>',
            cover: '../portada/albums/<?php echo addslashes($cancion['cover']); ?>',
            audio: '../musica/<?php echo addslashes($cancion['album_folder'] ?? $cancion['nom_album']); ?>/<?php echo addslashes($cancion['audio']); ?>',
            duration: '<?php echo addslashes($cancion['duracion']); ?>',
            id: <?php echo $cancion['id_cancion']; ?>
        },
        <?php endforeach; ?>
    ];
</script>
<script>
    // Carga las canciones en modo normal (no playlist)
    const allSongs = [ /* tus canciones... */ ];
    loadSongs(allSongs, false); // Segundo parámetro false = modo normal
</script>
    <script src="../js/script.js"></script>
</body>
</html>

