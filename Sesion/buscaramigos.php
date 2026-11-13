<?php
    $mensaje = "";
    $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

    session_start();
    if (isset($_SESSION['usuario'])) {
        $correo = $_SESSION['usuario'];

        $sqlUsuario = "SELECT id FROM registro WHERE email = '$correo'";
        $usuario = mysqli_query($conexion, $sqlUsuario);

        if ($usuario && mysqli_num_rows($usuario) > 0) {
            $filaUsuario = mysqli_fetch_assoc($usuario);
            $mi_id = $filaUsuario['id'];
        } else {
            die("No se pudo obtener la ID del usuario.");
        }

        $sql = "
            SELECT r.id, r.fotoperfil, r.nombre, r.apellidos, r.email
            FROM registro r
            WHERE r.id != '$mi_id'
            AND r.id NOT IN (
                SELECT id_amigo FROM amigos WHERE mi_id = '$mi_id'
            )
            AND r.id NOT IN (
                SELECT solicitado_id FROM solicitudes_amistad WHERE solicitante_id = '$mi_id' AND estado = 'pendiente'
            )
        ";
        $resultado = mysqli_query($conexion, $sql);

        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }
    }

    if (isset($_POST['btnAgregar'])) {
        $id_amigo = $_POST['id_amigo'];

        $sqlInsertarSolicitud = "INSERT INTO solicitudes_amistad (solicitante_id, solicitado_id, estado) 
                                VALUES ('$mi_id', '$id_amigo', 'pendiente')";
        if (mysqli_query($conexion, $sqlInsertarSolicitud)) {
            $mensaje = "Solicitud de amistad enviada.";
        } else {
            $mensaje = "Error al enviar la solicitud: " . mysqli_error($conexion);
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/buscaramigos.css">
    <title>Buscar Amigos</title>
</head>
<body>
    <header>
        <nav>
            <center>
                <ul>
                    <li><a href="miperfil.php"><img src="../Imagenes/usuarioNO.png" alt="perfil" class="imagen"><br>Mi Perfil</a></li>
                    <li><a href="misamigos.php"><img src="../Imagenes/amigosNO.png" alt="amigos" class="imagen"><br>Mis Amigos</a></li>
                    <li><a href="misfotos.php"><img src="../Imagenes/fotosNO.png" alt="fotos" class="imagen"><br>Mis Fotos</a></li>
                    <li><a href="#"><img src="../Imagenes/buscarNO.png" alt="buscaramigos" class="imagen"><br>Buscar Amigos</a></li>
                    <li><a href="solicitud.php"><img src="../Imagenes/solicitudesNO.png" alt="soli" class="imagen"><br>Solicitudes</a></li>
                    <li><a href="cerrarsesion.php"><img src="../Imagenes/cerrarNo.png" alt="cerrar" class="imagen"><br>Cerrar Sesión</a></li>
                </ul>
            </center>
        </nav>
    </header>
    <main>
        <section class="seccion">
            <?php
                if (!empty($mensaje)) {
                    echo "<p>$mensaje</p>";
                }

                if (isset($resultado) && mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        $id_amigo = $fila['id'];
                        $fotoperfil = $fila['fotoperfil'];
                        $nombre = $fila['nombre'];
                        $apellidos = $fila['apellidos'];
                        $email = $fila['email'];

                        echo "<div class='contenedor'>";
                        echo "<form method='POST'>";
                        echo "<img src='$fotoperfil' alt='Foto de $nombre' class='fotoperfil'>";
                        echo "<p>$nombre $apellidos</p>";
                        echo "<input type='hidden' name='id_amigo' value='$id_amigo'>";
                        echo "<button type='submit' name='btnAgregar'>Enviar Solicitud</button>";
                        echo "<button type='submit' class='boton' name='btnEliminar' value='$id_amigo'>Ver Perfil</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No se encontraron usuarios disponibles para agregar.</p>";
                }

                if (isset($conexion)) {
                    mysqli_close($conexion);
                }
            ?>
        </section>
    </main>
</body>
</html>
