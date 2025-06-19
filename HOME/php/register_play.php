<?php
session_start();
require_once __DIR__ . '/../../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../altausuario.html");
    exit();
}

if (!isset($_POST['song_id'])) {
    exit('ID de canción no proporcionado');
}

$userId = $_SESSION['usuario_id'];
$songId = intval($_POST['song_id']);

// Registrar la reproducción en la base de datos
$sql = "INSERT INTO reproducciones (id_usu, id_cancion, fecha) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $songId);

if ($stmt->execute()) {
    // Opcional: Actualizar contador de reproducciones en la tabla canciones
    $update_sql = "UPDATE canciones SET reproducciones = reproducciones + 1 WHERE id_cancion = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $songId);
    $update_stmt->execute();
    
    echo 'Reproducción registrada correctamente';
} else {
    echo 'Error al registrar la reproducción: ' . $conn->error;
}
?>

