<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cerrar Sesión - RhythmoTune</title>
    <style>
        :root {
            --primary-color: #1DB954;
            --dark-bg: #0e0e15;
            --text-color: #ffffff;
            --text-secondary: #b3b3b3;
            --accent-color: #ff4d4d;
            --font-main: 'Segoe UI', Roboto, sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-main);
            background-color: var(--dark-bg);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
        }
        
        .logo {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .logout-container {
            background-color: rgba(30, 30, 46, 0.8);
            padding: 3rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }
        
        h2 {
            margin-bottom: 1.5rem;
            color: var(--text-color);
            font-size: 1.8rem;
        }
        
        .login-link {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.8rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        
        .login-link:hover {
            background-color: #1ed760;
            transform: translateY(-2px);
        }
        
        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .logout-container {
                padding: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="logo">RhythmoTune</div>
    <div class="logout-container">
        <div class="icon">👋</div>
        <h2>Has cerrado sesión correctamente</h2>
        <p>Gracias por usar nuestro servicio. Esperamos verte pronto de nuevo.</p>
        <a href="../../altausuario.html" class="login-link">Volver al inicio de sesión</a>
    </div>
</body>
</html>

