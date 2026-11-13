<?php
    $mensaje = "";

    if (isset($_POST['btnIniciarSesion'])) {
        $correo = $_POST['correo'];
        $pass = $_POST['contra'];

        $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

        if ($conexion) {
            $consulta = "SELECT pass FROM registro WHERE email = '$correo'";
            $resultado = mysqli_query($conexion, $consulta);

            if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
                if ($pass === $fila['pass']) {
                    session_start();
                    $_SESSION['usuario'] = $correo;
                    header("Location: Sesion/miperfil.php");
                    exit();
                } else {
                    $mensaje = "Contraseña incorrecta.";
                }
            } else {
                $mensaje = "No se encontró una cuenta con ese correo electrónico.";
            }

            mysqli_close($conexion);
        } else {
            $mensaje = "No se pudo conectar a la base de datos.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="shortcut icon" href="Imagenes/coyote1.png" type="image/x-icon">
    <script src="JS/vSesion.js"></script>
    <link rel="stylesheet" href="css/validacion.css">
</head>
<body>
    <main>
        <img src="Imagenes/unnamed2.png" alt="coyote" class="fondocoyote">
        <section>
            <center>
                <form action="" method="post" id="formulario">
                    <p class="cbtis"><br>
                        <label for="gram">COYOTEgram</label>
                    </p><br>
                    <p>
                        <label for="correo">Correo Electronico : </label><br>
                        <i id="iconoUsuario"></i>
                        <input type="email" name="correo" id="correo" placeholder="correo electronico" autocomplete="off" required pattern="^([a-zA-Z0-9_\-\.]+)(2225|2326|2427)(@cbtis198.edu.mx)">
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="contra">Contraseña : </label><br>
                        <i id="iconoPassword"></i>
                        <input type="password" name="contra" id="contra" placeholder="contraseña" autocomplete="off" required minlength="8" pattern="(?=.*[0-9])(?=.*[A-ZÑ_])(?=.*[a-zñ])(?=.*\W).+">
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <button type="submit" name="btnIniciarSesion" id="btnIniciarSesion">Iniciar Sesion</button>
                    </p>
                </form>
                <p><br><br>
                    <label for="registro">¿No tienes una cuenta?</label><br><br>
                    <button onclick="location.href='Sesion/registrarse.php'">Registrate</button>
                </p>
                <span>
                    <?php
                        echo $mensaje;
                    ?>
                </span>
            </center>
        </section>
    </main>
</body>
</html>