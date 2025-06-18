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
                    <li class="nav-item"><a href="bien.php">Home</a></li>
                    <li class="nav-item"><a href="./artistas.php">Artistas</a></li>
                    <li class="nav-item active"><a href="playlists.php">Mis Playlists</a></li>
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
                <h2 class="section-title">🎵 Tus Playlists</h2>
                <a href="crear_playlist.php" class="create-playlist-btn">+ Crear nueva playlist</a>
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
</body>
</html>