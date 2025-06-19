<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../altausuario.html");
    exit();
}

require_once __DIR__ . '/../../conexion.php';

$playlist_id = $_GET['id'] ?? 0;
$usuario_id = $_SESSION['usuario_id'];

// Verificar que la playlist pertenece al usuario
$sql = "SELECT id_playlist FROM playlists WHERE id_playlist = ? AND id_usu = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $playlist_id, $usuario_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die("Playlist no encontrada");
}

// Obtener canciones disponibles
$sql_canciones = "SELECT 
                    c.id_cancion, 
                    c.nom_cancion, 
                    a.nom_album, 
                    a.portada_album, 
                    a.nombre_directorio, 
                    ar.nom_artista 
                FROM canciones c
                JOIN albums a ON c.id_album = a.id_album
                JOIN artistas ar ON a.id_artista = ar.id_artista
                WHERE c.id_cancion NOT IN (
                    SELECT id_cancion FROM canciones_playlists 
                    WHERE id_playlist = ?
                )";
$stmt = mysqli_prepare($conn, $sql_canciones);
mysqli_stmt_bind_param($stmt, "i", $playlist_id);
mysqli_stmt_execute($stmt);
$canciones = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['canciones'])) {
        $sql_insert = "INSERT INTO canciones_playlists (id_playlist, id_cancion) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        
        foreach ($_POST['canciones'] as $cancion_id) {
            mysqli_stmt_bind_param($stmt_insert, "ii", $playlist_id, $cancion_id);
            mysqli_stmt_execute($stmt_insert);
        }
        
        header("Location: ver_playlist.php?id=$playlist_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir canciones</title>
    <link rel="stylesheet" href="../css/style.css">
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
        <h2>Añadir canciones a la playlist</h2>
        
        <form method="POST">
            <div class="song-list-add">
                <?php if (!empty($canciones)): ?>
                    <?php foreach ($canciones as $cancion): ?>
                        <button type="submit" name="canciones[]" value="<?php echo $cancion['id_cancion']; ?>" class="song-add-item">
                            <img src="../portada/albums/<?php echo htmlspecialchars($cancion['portada_album'] ?: 'album-placeholder.png'); ?>" alt="Portada">
                            <div class="song-info-add">
                                <?php echo htmlspecialchars($cancion['nom_cancion']); ?>
                                <span><?php echo htmlspecialchars($cancion['nom_artista']); ?> • <?php echo htmlspecialchars($cancion['nom_album']); ?></span>
                            </div>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-songs-message">No hay canciones disponibles para añadir</p>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <a href="ver_playlist.php?id=<?php echo $playlist_id; ?>" class="btn-secondary">Volver</a>
            </div>
        </form>
    
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
                    <a href="https://www.instagram.com/" target="_blank"><img src="../iconos/1.png" alt="Instagram"></a>
                    <a href="https://www.x.com/" target="_blank"><img src="../iconos/3.png" alt="Twitter/X"></a>
                    <a href="https://www.facebook.com/" target="_blank"><img src="../iconos/2.png" alt="Facebook"></a>
                    <a href="https://www.linkedin.com/" target="_blank"><img src="../iconos/4.png" alt="LinkedIn"></a>
                </div>
            </div>
            
            <div class="copyright">
                <span>© 2025 RhythmoTune - Salesianas</span>
            </div>
        </footer>
    </main>
</body>
</html>