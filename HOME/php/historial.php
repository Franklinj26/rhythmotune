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

// Obtener el historial de reproducción del usuario con la misma estructura que tu consulta funcional
$sql = "SELECT 
            c.id_cancion, 
            c.nom_cancion, 
            a.nom_album, 
            a.portada_album, 
            a.nombre_directorio, 
            ar.nom_artista,
            r.fecha
        FROM reproducciones r
        JOIN canciones c ON r.id_cancion = c.id_cancion
        JOIN albums a ON c.id_album = a.id_album
        JOIN artistas ar ON a.id_artista = ar.id_artista
        WHERE r.id_usu = ?
        ORDER BY r.fecha DESC
        LIMIT 20";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$historial = $result->fetch_all(MYSQLI_ASSOC);
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
            background: #0a1a2f; /* Azul oscuro elegante */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
            color: white; /* Texto blanco */
            display: flex;
            flex-direction: column;
            height: 100%;
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
        
        .history-date {
            font-size: 12px;
            color: #b8c7e0;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid rgba(255,255,255,0.1);
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
                    <li class="nav-item"><a href="bien.php">Home</a></li>
                    <li class="nav-item"><a href="./artistas.php">Artistas</a></li>
                    <li class="nav-item"><a href="playlists.php">Mis Playlists</a></li>
                    <li class="nav-item"><a href="./reproducciones.php">Canciones Escuchadas</a></li>
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
                    <div class="history-item">
                        <div class="history-image-container">
                            <img src="../portada/albums/<?php echo htmlspecialchars($cancion['portada_album'] ?: 'album-placeholder.png'); ?>" 
                                 alt="Portada de <?php echo htmlspecialchars($cancion['nom_album']); ?>">
                        </div>
                        <div class="history-info">
                            <h3 class="song-title"><?php echo htmlspecialchars($cancion['nom_cancion']); ?></h3>
                            <p class="artist-name"><?php echo htmlspecialchars($cancion['nom_artista']); ?></p>
                            <p class="album-name"><?php echo htmlspecialchars($cancion['nom_album']); ?></p>
                            <p class="history-date">
                                Escuchado el <?php echo date('d/m/Y H:i', strtotime($cancion['fecha'])); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-songs">No has reproducido ninguna canción todavía.</p>
            <?php endif; ?>
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
</body>
</html>