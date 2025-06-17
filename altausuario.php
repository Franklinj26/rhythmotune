<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Registro</title>
</head>

<body>
    <div class="container">
        <div class="form-contents">
            <h1 id="title">Bienvenido</h1>
            <?php
              session_start();
              require 'limpiar.php';
            
              /* Comprobamos que llegan todos los datos del formulario */

              if (!isset($_POST["name"]) || !isset($_POST["mail"]) || !isset($_POST["pass"]))
                die("Acceso denegado");

              /* Limpiamos los datos */

              $name = test_input($_POST["name"]);
              $mail = test_input($_POST["mail"]);
              $pass = test_input($_POST["pass"]);
              $tipo = test_input($_POST["tipo_cuenta"]);
              $fecha = date("Y-m-d H:i:s");

              /* Incluimos las instrucciones de conexión a la bbdd */

              require 'conexion.php';
            // -----------------------------
            //        REGISTRO
            // -----------------------------
            if (isset($_POST['registro'])) {
            /* Comprobamos que no están vacíos después de limpiarlos */
              if ($name=="" || $mail=="" || $pass=="" || $fecha==""|| $tipo=="")
              die ("No puede haber campos vacíos");
                // Verificar si ya existe el correo
                $sql = "SELECT * FROM usuarios WHERE correo='$mail'";
                $resultado = mysqli_query($conn, $sql);

                if (mysqli_num_rows($resultado) > 0) {
                    echo "<p style='color:#FFFFFF'> El correo ya está registrado. Prueba a <a href='altausuario.html' style='text-decoration: none; color: #FFFFFF;'>iniciar sesión.</a></p>";
                } else {
                    // Insertar nuevo usuario
                    $sql = "INSERT INTO usuarios (id_usu, nom_usu, correo, contraseña, f_registro, id_cuenta)
                            VALUES (0, '$name', '$mail', '$pass', '$fecha', '$tipo')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<p style='color:#FFFFFF'>✅ Registro exitoso. Ya puedes <a href='altausuario.html' style='text-decoration: none; color: #FFFFFF;'> iniciar sesión.</a></p>";
                    } else {
                        echo "<p style'=color:#FFFFFF'>❌ Error al registrar: " . mysqli_error($conn)."</p>";
                    }
                }
            }

            // -----------------------------
            //        INICIO DE SESIÓN
            // -----------------------------
            if (isset($_POST['login'])) {
                $sql = "SELECT * FROM usuarios WHERE correo='$mail' AND contraseña='$pass'";
                $resultado = mysqli_query($conn, $sql);

                if (mysqli_num_rows($resultado) > 0) {
                    $usuario = mysqli_fetch_assoc($resultado);

                    $_SESSION['usuario_id'] = $usuario['id_usu'];
                    $_SESSION['usuario_nombre'] = $usuario['nom_usu'];

                    // Redirigir a la página de inicio personalizada
                    header("Location: HOME/php/bien.php");
                    exit();
                } else {
                    echo "<p style='color:#FFFFFF'>❌ Correo o contraseña incorrectos.";
                }
            }

            mysqli_close($conn);
            ?>


        </div>
    </div>

    <script src="js/script.js"></script>
</body>

</html>