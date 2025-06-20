<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../../conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['usuario_id'];

// Consulta modificada para agrupar por canción y contar reproducciones
$sql_historial = "SELECT 
            c.id_cancion, 
            c.nom_cancion, 
            a.nom_album, 
            a.portada_album, 
            a.nombre_directorio, 
            ar.nom_artista,
            c.ruta_audio,
            COUNT(r.id_reproduccion) as reproducciones,
            MAX(r.fecha) as ultima_reproduccion
        FROM canciones c
        JOIN albums a ON c.id_album = a.id_album
        JOIN artistas ar ON a.id_artista = ar.id_artista
        JOIN reproducciones r ON c.id_cancion = r.id_cancion
        WHERE r.id_usu = $userId
        GROUP BY c.id_cancion
        ORDER BY reproducciones DESC, ultima_reproduccion DESC
        LIMIT 20";
$sql_todas_canciones = "SELECT c.id_cancion, c.nom_cancion, a.nom_album, a.portada_album, 
        a.nombre_directorio, ar.nom_artista, c.ruta_audio
        FROM canciones c
        JOIN albums a ON c.id_album = a.id_album
        JOIN artistas ar ON a.id_artista = ar.id_artista";
$result_todas = mysqli_query($conn, $sql_todas_canciones);
$todas_las_canciones = mysqli_fetch_all($result_todas, MYSQLI_ASSOC);

$result_historial = mysqli_query($conn, $sql_historial);
$historial = mysqli_fetch_all($result_historial, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi historial de reproducción</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .history-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            padding: 25px;
        }
        
        .history-item {
            background: #0a1a2f;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
            color: white;
            display: flex;
            flex-direction: column;
            height: 100%;
            cursor: pointer;
        }
        
        .history-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        
        .history-image-container {
            width: 100%;
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        
        .history-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .history-item:hover img {
            transform: scale(1.05);
        }
        
        .history-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .song-title {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
        }
        
        .artist-name {
            margin: 0 0 5px 0;
            font-size: 15px;
            color: #a0c4ff;
        }
        
        .album-name {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #7f9cd4;
            font-style: italic;
        }
        
        .history-stats {
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .play-count {
            font-size: 13px;
            color: #1db954;
            font-weight: 600;
        }
        
        .history-date {
            font-size: 12px;
            color: #b8c7e0;
        }
        
        .page-title {
            padding: 25px;
            margin: 0;
            color: white;
            font-size: 28px;
        }
        
        .no-songs {
            color: white;
            padding: 20px;
            text-align: center;
            grid-column: 1 / -1;
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
        <h2 class="page-title">Mi historial de reproducción</h2>
        
        <div class="history-container">
            <?php if (!empty($historial)): ?>
                <?php foreach ($historial as $cancion): ?>
                    <div class="history-item" onclick="playSongFromCard({
                        title: '<?php echo htmlspecialchars($cancion['nom_cancion']); ?>',
                        artist: '<?php echo htmlspecialchars($cancion['nom_artista']); ?>',
                        cover: '../portada/albums/<?php echo htmlspecialchars($cancion['portada_album'] ?: 'album-placeholder.png'); ?>',
                        audio: '../musica/<?php echo htmlspecialchars($cancion['nombre_directorio']); ?>/<?php echo htmlspecialchars($cancion['ruta_audio']); ?>',
                        id: <?php echo $cancion['id_cancion']; ?>
                    })">
                        <div class="history-image-container">
                            <img src="../portada/albums/<?php echo htmlspecialchars($cancion['portada_album'] ?: 'album-placeholder.png'); ?>" 
                                 alt="Portada de <?php echo htmlspecialchars($cancion['nom_album']); ?>">
                        </div>
                        <div class="history-info">
                            <h3 class="song-title"><?php echo htmlspecialchars($cancion['nom_cancion']); ?></h3>
                            <p class="artist-name"><?php echo htmlspecialchars($cancion['nom_artista']); ?></p>
                            <p class="album-name"><?php echo htmlspecialchars($cancion['nom_album']); ?></p>
                            <div class="history-stats">
                                <span class="play-count"><?php echo $cancion['reproducciones']; ?> reproducciones</span>
                                <span class="history-date">
                                    Última vez: <?php echo date('d/m/Y H:i', strtotime($cancion['ultima_reproduccion'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-songs">No has reproducido ninguna canción todavía.</p>
            <?php endif; ?>
        </div>

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

    <script>
    const allSongs = <?php echo json_encode(array_map(function($cancion) {
        return [
            'id' => $cancion['id_cancion'],
            'title' => $cancion['nom_cancion'],
            'artist' => $cancion['nom_artista'],
            'album' => $cancion['nom_album'],
            'cover' => '../portada/albums/'.($cancion['portada_album'] ?: 'album-placeholder.png'),
            'audio' => '../musica/'.$cancion['nombre_directorio'].'/'.$cancion['ruta_audio'],
            'duration' => '0:00' // Puedes calcular esto si tienes la duración en la BD
        ];
    }, $todas_las_canciones)); ?>;

document.addEventListener('DOMContentLoaded', function() {
            if (typeof loadState === 'function') {
                loadState();
            }
            
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
        <script src="../js/script.js"></script>

</body>
</html>