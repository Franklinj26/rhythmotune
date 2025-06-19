<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../../altausuario.html");
  exit();
}

require '../../conexion.php';

if (!isset($_GET['id_artista'])) {
  header("Location: artistas.php");
  exit();
}

$id_artista = intval($_GET['id_artista']);

// Obtener info del artista
$sql_artista = "SELECT nom_artista, foto_artista FROM artistas WHERE id_artista = $id_artista";
$res_artista = mysqli_query($conn, $sql_artista);
if (!$res_artista || mysqli_num_rows($res_artista) === 0) {
  header("Location: artistas.php");
  exit();
}
$artista = mysqli_fetch_assoc($res_artista);

// Obtener solo los álbumes del artista
$sql_albumes = "SELECT 
    a.id_album, 
    a.nom_album, 
    a.portada_album,
    COUNT(c.id_cancion) AS num_canciones
FROM albums a
LEFT JOIN canciones c ON a.id_album = c.id_album
WHERE a.id_artista = $id_artista
GROUP BY a.id_album
ORDER BY a.año DESC";

$albumes = mysqli_fetch_all(mysqli_query($conn, $sql_albumes), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($artista['nom_artista']); ?> - RhythmoTune</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .artist-header {
      display: flex;
      align-items: center;
      gap: 30px;
      margin-bottom: 40px;
    }
    
    .artist-image {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--accent-color);
    }
    
    .albums-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }
    
    .album-card {
      cursor: pointer;
      transition: transform 0.3s;
    }
    
    .album-card:hover {
      transform: scale(1.05);
    }
    
    .album-cover {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    
    .album-info {
      padding: 0 5px;
    }
    
    .album-title {
      font-weight: 500;
      margin-bottom: 5px;
    }
    
    .album-songs {
      color: var(--text-secondary);
      font-size: 0.9rem;
    }
    
    .back-link {
      display: inline-block;
      margin-top: 30px;
      color: var(--primary-color);
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
          <a href="https://www.instagram.com/rhythmotune/" target="_blank"><img src="../iconos/1.png" alt="Instagram"></a>
                    <a href="https://x.com/rhythmotun28714" target="_blank"><img src="../iconos/3.png" alt="Twitter/X"></a>
                    <a href="https://www.facebook.com/profile.php?id=61577711155281" target="_blank"><img src="../iconos/2.png" alt="Facebook"></a>
                    <a href="https://www.linkedin.com/in/rhythmo-tune-7905a2370/" target="_blank"><img src="../iconos/4.png" alt="LinkedIn"></a>
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

    <section class="artist-section">
      <div class="artist-header">
        <?php if (!empty($artista['foto_artista'])): ?>
          <img src="../portada/artistas/<?php echo htmlspecialchars($artista['foto_artista']); ?>" 
               alt="<?php echo htmlspecialchars($artista['nom_artista']); ?>" 
               class="artist-image">
        <?php else: ?>
          <img src="../iconos/artist-placeholder.png" alt="Artista sin foto" class="artist-image">
        <?php endif; ?>
          
        <div class="artist-info">
          <h1><?php echo htmlspecialchars($artista['nom_artista']); ?></h1>
          <p><?php echo count($albumes); ?> álbumes disponibles</p>
        </div>
      </div>

      <h2 class="section-title">Álbumes</h2>
      
      <div class="albums-grid">
        <?php if (!empty($albumes)): ?>
          <?php foreach ($albumes as $album): ?>
            <div class="album-card" onclick="window.location.href='ver_album.php?id=<?php echo $album['id_album']; ?>'">
              <?php if (!empty($album['portada_album'])): ?>
                <img src="../portada/albums/<?php echo htmlspecialchars($album['portada_album']); ?>" 
                     alt="<?php echo htmlspecialchars($album['nom_album']); ?>" 
                     class="album-cover">
              <?php else: ?>
                <img src="../iconos/album-placeholder.png" 
                     alt="Álbum sin portada" 
                     class="album-cover">
              <?php endif; ?>

              <div class="album-info">
                <h3 class="album-title"><?php echo htmlspecialchars($album['nom_album']); ?></h3>
                <p class="album-songs"><?php echo $album['num_canciones']; ?> canciones</p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Este artista no tiene álbumes registrados</p>
        <?php endif; ?>
      </div>
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

    <a href="artistas.php" class="back-link">⬅️ Volver a artistas</a>

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

