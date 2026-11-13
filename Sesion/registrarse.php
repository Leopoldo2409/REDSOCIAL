<?php  
    $mensaje = " ";
    if (isset($_POST['btnRegistrar'])) {
        $email = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $edad = $_POST['edad'];
        $descripcion = $_POST['desc'];
        $pass = $_POST['contra'];
        $fotoperfil = $_FILES['fotoPerfil'];

        $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");
        $foto = "";
        $foto = basename($fotoperfil['name']);        
        $carpeta = "../fotodeperfil/";
        $ruta_foto = $carpeta.$foto;

        if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)) {
            $mensaje = "Error del sistema";
            exit;
        }
        $foto = uniqid('perfil_', true) . '.' . pathinfo($fotoperfil['name'], PATHINFO_EXTENSION);
        $ruta_foto = $carpeta . $foto;

        if (!move_uploaded_file($fotoperfil['tmp_name'], $ruta_foto)) {
            $mensaje = "Error del sistema";
            exit;
        }

        if ($conexion) {
            $sql = "INSERT INTO registro (email, nombre, apellidos, edad, descripcion, pass,fotoperfil) 
            VALUES ('{$email}', '{$nombre}', '{$apellidos}', {$edad}, '{$descripcion}', '{$pass}','{$ruta_foto}')";

            if (mysqli_query($conexion, $sql)) {
                $mensaje = "Datos guardados correctamente.";
            } else {
                $mensaje = "Error al guardar los datos.";
            }
        } else {
            $mensaje = "No se pudo conectar a la base de datos: " . mysqli_connect_error();
        }

        if ($conexion) {
            mysqli_close($conexion);
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <script src="../JS/validaIngresarU.js"></script>
    <link rel="stylesheet" href="../css/validacion.css">
    <link rel="shortcut icon" href="../Imagenes/coyote1.png" type="image/x-icon" class="icono">
</head>
<body>
    <main>
        <img src="../Imagenes/unnamed2.png" alt="coyote" class="coyote2">
            <section class="registroo">
                <center>
                <p><br>
                    <label for="registrate" class="rtitulo">Registro</label> <br><br>
                </p>
                <form action="" method="post" enctype="multipart/form-data" id="formulario">
                    <p>
                        <label for="correo">Email : </label>
                        <i id="iconoUsuario"></i>
                        <input type="email" name="correo" id="correo" autocomplete="off" placeholder="Correo electronico" required pattern="^([a-zA-Z0-9_\-\.]+)(2225|2326|2427)@cbtis198.edu.mx">
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="nombre">Nombre(s) : </label>
                        <i id="iconoNombre"></i>
                        <input type="text" name="nombre" id="nombre" autocomplete="off" placeholder="Nombre" pattern="[a-zñáéíóú A-ZÑÁÉÍÓÚ ]+" required>
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="apellidos">Apellidos : </label>
                        <i id="iconoApe"></i>
                        <input type="text" name="apellidos" id="apellidos" autocomplete="off" placeholder="Apellidos" pattern="[a-zñáéíóú A-ZÑÁÉÍÓÚ ]+" required>
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="edad">Edad :</label>
                        <i id="iconoEdad"></i>
                        <input type="number" name="edad" id="edad" placeholder="Edad" required min="13">
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="desc">Descripción : </label>
                        <i id="iconoDesc"></i>
                        <input type="text" name="desc" id="desc" autocomplete="off" placeholder="Descripción" required>
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="contra">Contraseña :</label>
                        <i id="iconoPassword"></i>
                        <input type="password" name="contra" id="contra" autocomplete="off" placeholder="Contraseña"required minlength="8" pattern="(?=.*[0-9])(?=.*[A-ZÑ_])(?=.*[a-zñ])(?=.*\W).+">
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="Concontra">Confirmar contraseña :</label>
                        <i id="iconoPassword2"></i>
                        <input type="password" name="Concontra" id="Concontra" autocomplete="off" placeholder="Contraseña"required minlength="8" pattern="(?=.*[0-9])(?=.*[A-ZÑ_])(?=.*[a-zñ])(?=.*\W).+">
                        <span class="error"></span>
                    </p><br>
                    <p>
                        <label for="fotoPerfil">Foto de perfil</label><br>
                        <input type="file" name="fotoPerfil" id="fotoPerfil" accept=".png,.jpg">
                    </p><br>
                    <p>
                        <input type="hidden" name="fecharegistro" value="CurrentDate">
                    </p>
                    <p>
                        <button type="submit" name="btnRegistrar" id="btnRegistrar">Registrarse</button>
                        <button onclick="location.href='../index.php'">Regresar</button>
                    </p>
                </form>
                </center>
                <span>
                    <?php
                        echo $mensaje;
                    ?>
                </span>
            </section>
        </center>
    </main>
</body>
</html>