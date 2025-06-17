<?php
session_start();
require_once __DIR__ . '/../../conexion.php';

if (!isset($_SESSION['usuario_id']) || !isset($_POST['song_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

$songId = intval($_POST['song_id']);
$userId = $_SESSION['usuario_id'];

// Actualizar contador de reproducciones
$sql = "UPDATE canciones 
        SET reproducciones = reproducciones + 1 
        WHERE id_cancion = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $songId);
$success = $stmt->execute();

// Registrar en historial de reproducción
if ($success) {
    $sql_history = "INSERT INTO reproducciones (id_usuario, id_cancion, fecha) 
                    VALUES (?, ?, NOW())";
    $stmt_history = $conn->prepare($sql_history);
    $stmt_history->bind_param("ii", $userId, $songId);
    $stmt_history->execute();
}

echo json_encode(['success' => $success]);
?>