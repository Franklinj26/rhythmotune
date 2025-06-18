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
session_start();
require 'conexion.php';
require 'limpiar.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
    echo "<p style='color:red;'>Error: $error</p>";

    $tarjeta = isset($_GET['tarjeta']) ? urlencode($_GET['tarjeta']) : '';
    $fecha = isset($_GET['fecha_caducidad']) ? urlencode($_GET['fecha_caducidad']) : '';
    $cvv = isset($_GET['cvv']) ? urlencode($_GET['cvv']) : '';

    echo "<p><a href='datos_tarjeta.php?tarjeta={$tarjeta}&fecha_caducidad={$fecha}&cvv={$cvv}'>Volver y corregir datos</a></p>";
    exit();
}

if (!isset($_SESSION['nuevo_usuario'])) {
    header("Location: altausuario.html");
    exit();
}

$id_usuario = $_SESSION['nuevo_usuario'];
$tarjeta = test_input($_POST['tarjeta']);
$cvv = test_input($_POST['cvv']);
$fecha_caducidad = test_input($_POST['fecha_caducidad']);
$subtipo = test_input($_POST['subtipo_premium']);

$tarjeta_hashed = password_hash($tarjeta, PASSWORD_BCRYPT);
$cvv_hashed = password_hash($cvv, PASSWORD_BCRYPT);
$fecha_caducidad_hashed = password_hash($fecha_caducidad, PASSWORD_BCRYPT);

$stmt = mysqli_prepare($conn, "INSERT INTO tarjetas (id_usu, tarjeta_hash, cvv_hash, fecha_caducidad_hash, tipo_premium) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "issss", $id_usuario, $tarjeta_hashed, $cvv_hashed, $fecha_caducidad_hashed, $subtipo);

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['nuevo_usuario']);
    echo "<p style='color:#FFF'>✅ Registro completo. <a href='altausuario.html'>Iniciar sesión</a></p>";
} else {
    echo "<p style='color:#FFF'>❌ Error al guardar la tarjeta: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>

</div>
    </div>
</body>
</html>