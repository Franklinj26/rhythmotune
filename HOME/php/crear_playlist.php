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

// Procesar el formulario si se envió
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_playlist = trim($_POST['nombre_playlist'] ?? '');
    
    if (empty($nombre_playlist)) {
        $error = 'El nombre de la playlist no puede estar vacío';
    } else {
        // Insertar la nueva playlist
        $sql = "INSERT INTO playlists (nom_playlist, id_usu, f_creacion) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $nombre_playlist, $usuario_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $playlist_id = mysqli_insert_id($conn);
            $mensaje = 'Playlist creada correctamente';
            // Redirigir a la nueva playlist después de 2 segundos
            header("Refresh: 2; url=ver_playlist.php?id=".$playlist_id);
        } else {
            $error = 'Error al crear la playlist: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crear Nueva Playlist - RhythmoTune</title>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        .create-playlist-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid var(--category-bg);
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            font-size: 16px;
        }
        
        .form-submit {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .form-submit:hover {
            background-color: #1ed760;
        }
        
        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .success {
            background-color: rgba(29, 185, 84, 0.2);
            color: var(--primary-color);
        }
        
        .error {
            background-color: rgba(255, 77, 77, 0.2);
            color: var(--accent-color);
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
        </header>

        <section class="create-playlist-section">
            <div class="create-playlist-container">
                <h2 class="section-title">Crear Nueva Playlist</h2>
                
                <?php if ($mensaje): ?>
                    <div class="message success"><?php echo $mensaje; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="message error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="crear_playlist.php">
                    <div class="form-group">
                        <label for="nombre_playlist" class="form-label">Nombre de la Playlist</label>
                        <input type="text" id="nombre_playlist" name="nombre_playlist" class="form-input" 
                               value="<?php echo htmlspecialchars($_POST['nombre_playlist'] ?? ''); ?>" 
                               required maxlength="100">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="form-submit">Crear Playlist</button>
                        <a href="playlists.php" class="btn-secondary" style="margin-left: 15px;">Cancelar</a>
                    </div>
                </form>
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

