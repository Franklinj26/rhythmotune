<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../../altausuario.html");
  exit();
}

require '../../conexion.php';

$sql = "SELECT id_artista, nom_artista, foto_artista FROM artistas ORDER BY nom_artista";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Artistas - RhythmoTune</title>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        /* Estilos adicionales específicos para artistas */
        .artists-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }
        
        .artist-link {
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease;
        }
        
        .artist-link:hover {
            transform: translateY(-5px);
        }
        
        .no-artists {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: var(--category-bg);
            border-radius: 50px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }
        
        .back-link:hover {
            background-color: var(--accent-color);
        }
        
        .search-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .search-bar {
            flex-grow: 1;
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
            <div class="search-container">
                <input type="text" placeholder="Buscar artistas..." class="search-bar" id="artistSearch"/>
                <button class="category-tag" onclick="searchArtists()">Buscar</button>
            </div>
        </header>

        <section class="music-section">
            <h2 class="section-title">Todos los Artistas</h2>
            
            <div class="artists-container" id="artistsGrid">
                <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                    <?php while ($artista = mysqli_fetch_assoc($resultado)): ?>
                        <a href="ver_artista.php?id_artista=<?php echo $artista['id_artista']; ?>" class="artist-link">
                            <div class="artist-card">
                                <?php if (!empty($artista['foto_artista'])): ?>
                                    <img src="../portada/artistas/<?php echo htmlspecialchars($artista['foto_artista']); ?>" alt="<?php echo htmlspecialchars($artista['nom_artista']); ?>">
                                    <?php else: ?>
                                    <img src="../iconos/artist-placeholder.png" alt="Artista sin foto">
                                <?php endif; ?>
                                <span><?php echo htmlspecialchars($artista['nom_artista']); ?></span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-artists">
                        <p>No hay artistas en la base de datos.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <a href="bien.php" class="back-link">⬅️ Volver al inicio</a>
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

    <script>
        // Función para búsqueda en tiempo real
        function searchArtists() {
            const input = document.getElementById('artistSearch');
            const filter = input.value.toUpperCase();
            const grid = document.getElementById('artistsGrid');
            const artists = grid.getElementsByClassName('artist-link');
            
            for (let i = 0; i < artists.length; i++) {
                const name = artists[i].querySelector('span').textContent.toUpperCase();
                if (name.includes(filter)) {
                    artists[i].style.display = "";
                } else {
                    artists[i].style.display = "none";
                }
            }
        }
        
        // Activar búsqueda al escribir
        document.getElementById('artistSearch').addEventListener('keyup', searchArtists);
    </script>
</body>
</html>