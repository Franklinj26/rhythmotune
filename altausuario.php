<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/styles.css" />
  <title>Registro</title>
</head>

<body>
    <div class="container">
        <div class="form-contents">
            <h1 id="title">Bienvenido</h1>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
require 'conexion.php';
require 'limpiar.php';

require 'HOME/php/Correo.php';

function hashData($data) {
    return password_hash($data, PASSWORD_BCRYPT);
}

// -----------------------------
//        REGISTRO
// -----------------------------
if (isset($_POST['registro'])) {
    if (!isset($_POST["name"], $_POST["mail"], $_POST["pass"], $_POST["tipo_cuenta"])) {
        die("<p style='color:#FFF'>❌ Datos incompletos. <a href='altausuario.html'>Volver</a></p>");
    }

    $name = test_input($_POST["name"]);
    $mail = test_input($_POST["mail"]);
    $pass = test_input($_POST["pass"]);
    $tipo = test_input($_POST["tipo_cuenta"]);
    $fecha = date("Y-m-d H:i:s");



    $stmt = mysqli_prepare($conn, "SELECT id_usu FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<p style='color:#FFF'>❌ El correo ya está registrado. <a href='altausuario.html'>Volver</a></p>";
        exit();
    }
    mysqli_stmt_close($stmt);

    $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (nom_usu, correo, contraseña, f_registro, id_cuenta) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $mail, $pass_hashed, $fecha, $tipo);

    if (mysqli_stmt_execute($stmt)) {
        $id_usuario = mysqli_insert_id($conn);
        if ($tipo == "2") {
            $_SESSION['nuevo_usuario'] = $id_usuario;
            header("Location: datos_tarjeta.php");
            exit();
        } else {
            echo "<p style='color:#FFF'>✅ Registro exitoso. <a href='altausuario.html'>Iniciar sesión</a></p>";
            $GestorCorreo = new Correo();
            $GestorCorreo->EnviarCorreo($mail, 'Registro hecho correctamente.', 'Nombre registrado: ' . $name . '<br>Correo registrado: ' . $mail);
        }
    } else {
        echo "<p style='color:#FFF'>❌ Error al registrar usuario: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
    }

    mysqli_stmt_close($stmt);
}

// -----------------------------
//        INICIO DE SESIÓN
// -----------------------------
if (isset($_POST['login'])) {
    if (!isset($_POST["mail"]) || !isset($_POST["pass"])) {
        die("<p style='color:#FFF'>❌ Datos incompletos. <a href='altausuario.html'>Volver</a></p>");
    }

    $mail = test_input($_POST["mail"]);
    $pass = test_input($_POST["pass"]);

    $stmt = mysqli_prepare($conn, "SELECT id_usu, nom_usu, contraseña FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        if (password_verify($pass, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id_usu'];
            $_SESSION['usuario_nombre'] = $usuario['nom_usu'];
            //Envio de correo electrónico
            $GestorCorreo = new Correo();
            $GestorCorreo->EnviarCorreo($mail, 'Se ha iniciado sesión correctamente.', 'Correo de sesión: ' . $mail);
            header("Location: HOME/php/bien.php");
            exit();
        } else {
            echo "<p style='color:#FFF'>❌ Contraseña incorrecta. <a href='altausuario.html'>Volver</a></p>";
        }
    } else {
        echo "<p style='color:#FFF'>❌ Correo no registrado. <a href='altausuario.html'>Volver</a></p>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

</div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
