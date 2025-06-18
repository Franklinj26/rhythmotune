<?php
session_start();
if (!isset($_SESSION['nuevo_usuario'])) {
    header("Location: altausuario.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos de Tarjeta</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-contents">
            <h2>Datos de Tarjeta</h2>
            <form action="procesar_pago.php" method="post">
                <div class="input-field">
                <input type="text" name="tarjeta" placeholder="Número de tarjeta" maxlength="16" required
                     value="<?= isset($_GET['tarjeta']) ? htmlspecialchars($_GET['tarjeta']) : '' ?>">
                </div>
                <div class="input-field">
                    <input type="text" name="fecha_caducidad" placeholder="MM/AA" maxlength="5" required
                       value="<?= isset($_GET['fecha_caducidad']) ? htmlspecialchars($_GET['fecha_caducidad']) : '' ?>">
                </div>
                <div class="input-field">
                    <input type="text" name="cvv" placeholder="CVV" maxlength="3" required
                       value="<?= isset($_GET['cvv']) ? htmlspecialchars($_GET['cvv']) : '' ?>">

                </div>
                <div class="tipo">
                    <label><input type="radio" name="subtipo_premium" value="individual" checked> Individual</label>
                    <label><input type="radio" name="subtipo_premium" value="familiar"> Familiar</label>
                </div>
                <button type="submit" name="confirmar_tarjeta">Confirmar pago</button>
            </form>
        </div>
    </div>
    <script src="js/validaciones_tarjeta.js"></script>
</body>
</html>
