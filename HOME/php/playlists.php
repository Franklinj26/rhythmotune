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

// Consulta para obtener las playlists del usuario
$sql_playlists = "SELECT id_playlist, nom_playlist, f_creacion 
                  FROM playlists 
                  WHERE id_usu = ? 
                  ORDER BY f_creacion DESC";
$stmt = mysqli_prepare($conn, $sql_playlists);
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
$playlists = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis Playlists - RhythmoTune</title>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        .playlists-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .playlist-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.3s;
            cursor: pointer;
        }
        
        .playlist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .playlist-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .playlist-date {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-top: 5px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            background-color: var(--card-bg);
            border-radius: 8px;
        }
        
        .create-playlist-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
        }
    </style>
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
                    <li class="nav-item"><a href="./historial.php">Canciones Escuchadas</a></li>
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
            <input type="text" placeholder="Buscar playlists..." class="search-bar"/>
        </header>

        <section class="music-section">
            <div class="section-header">
                <h2 class="section-title">Tus Playlists</h2>
                <a href="./crear_playlist.php" class="create-playlist-btn">Crear nueva playlist</a>
            </div>
            
            <?php if (!empty($playlists)): ?>
                <div class="playlists-grid">
                    <?php foreach ($playlists as $playlist): ?>
                        <div class="playlist-card" onclick="window.location.href='ver_playlist.php?id=<?php echo $playlist['id_playlist']; ?>'">
                            <div class="playlist-icon">🎵</div>
                            <h3><?php echo htmlspecialchars($playlist['nom_playlist']); ?></h3>
                            <p class="playlist-date">
                                Creada el <?php echo date('d/m/Y', strtotime($playlist['f_creacion'])); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tienes playlists aún</p>
                    <a href="crear_playlist.php" class="create-playlist-btn">Crea tu primera playlist</a>
                </div>
            <?php endif; ?>
     <!-- REPRODUCTOR MUSICAL -->
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
        </section>    
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
                    <a href="https://www.instagram.com/rhythmotune/" target="_blank"><img src="../iconos/1.png" alt="Instagram"></a>
                    <a href="https://x.com/rhythmotun28714" target="_blank"><img src="../iconos/3.png" alt="Twitter/X"></a>
                    <a href="https://www.facebook.com/profile.php?id=61577711155281" target="_blank"><img src="../iconos/2.png" alt="Facebook"></a>
                    <a href="https://www.linkedin.com/in/rhythmo-tune-7905a2370/" target="_blank"><img src="../iconos/4.png" alt="LinkedIn"></a>
                </div>
            </div>
            
            <div class="copyright">
                <span>© 2025 RhythmoTune - Salesianas</span>
            </div>
        </footer>
    </main>
    <script src="../js/script.js"></script>
    <script>
    // Inicialización común para todas las páginas
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar estado del reproductor si existe
        if (typeof loadState === 'function') {
            loadState();
        }
        
        // Configurar el control de volumen
        const volumeSlider = document.getElementById('volumeSlider');
        if (volumeSlider) {
            volumeSlider.addEventListener('input', function() {
                const audioPlayer = document.getElementById('audioPlayer');
                if (audioPlayer) {
                    audioPlayer.volume = this.value;
                }
            });
        }
    });
</script>
</body>
</html>

