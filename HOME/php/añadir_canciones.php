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
        <h2>Añadir canciones a la playlist</h2>
        
        <form method="POST" id="addSongsForm">
            <div class="song-list-add">
                <?php if (!empty($canciones)): ?>
                    <div class="select-all-container">
                        <label class="checkbox-container">
                            <input type="checkbox" id="selectAll">
                            <span class="checkmark"></span>
                            <span>Seleccionar todas</span>
                        </label>
                        <span id="selectedCounter" style="margin-left: 20px;">0 seleccionadas</span>
                    </div>
                    
                    <?php foreach ($canciones as $cancion): ?>
                        <div class="song-add-item">
                            <label class="checkbox-container">
                                <input type="checkbox" name="canciones[]" value="<?php echo $cancion['id_cancion']; ?>" class="song-checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <img src="../portada/albums/<?php echo htmlspecialchars($cancion['portada_album'] ?: 'album-placeholder.png'); ?>" alt="Portada">
                            <div class="song-info-add">
                                <?php echo htmlspecialchars($cancion['nom_cancion']); ?>
                                <span><?php echo htmlspecialchars($cancion['nom_artista']); ?> • <?php echo htmlspecialchars($cancion['nom_album']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-songs-message">No hay canciones disponibles para añadir</p>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Añadir canciones seleccionadas</button>
                <a href="ver_playlist.php?id=<?php echo $playlist_id; ?>" class="btn-secondary">Volver</a>
            </div>
        </form>
        <!-- Botón flotante para ir al final -->
<button class="floating-action-button" id="scrollToAddBtn" title="Ir a añadir canciones">↓</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const songCheckboxes = document.querySelectorAll('.song-checkbox');
        const selectedCounter = document.getElementById('selectedCounter');
        
        // Función para actualizar el contador
        function updateCounter() {
            const selectedCount = document.querySelectorAll('.song-checkbox:checked').length;
            selectedCounter.textContent = `${selectedCount} seleccionada${selectedCount !== 1 ? 's' : ''}`;
        }
        
        // Controlar el checkbox "Seleccionar todas"
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                songCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateCounter();
            });
        }
        
        // Controlar cuando se cambia cualquier checkbox de canción
        songCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Verificar si todas están seleccionadas
                const allChecked = Array.from(songCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
                updateCounter();
            });
        });
        
        // Actualizar contador al cargar la página
        updateCounter();
    });

// Botón flotante para ir al final
document.addEventListener('DOMContentLoaded', function() {
    // Crear el botón si no existe
    if (!document.getElementById('scrollToAddBtn')) {
        const button = document.createElement('button');
        button.id = 'scrollToAddBtn';
        button.className = 'floating-action-button';
        button.title = 'Ir a añadir canciones';
        button.innerHTML = '↓';
        document.body.appendChild(button);
    }
    
    const scrollToAddBtn = document.getElementById('scrollToAddBtn');
    const formActions = document.querySelector('.form-actions');
    
    if (scrollToAddBtn && formActions) {
        // Mostrar/ocultar botón al hacer scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 200) {
                scrollToAddBtn.classList.add('visible');
            } else {
                scrollToAddBtn.classList.remove('visible');
            }
        });
        
        // Scroll al hacer clic
        scrollToAddBtn.addEventListener('click', function(e) {
            e.preventDefault();
            formActions.scrollIntoView({
                behavior: 'smooth',
                block: 'end'
            });
        });
    }
});
    </script>
    
</body>
</html>

