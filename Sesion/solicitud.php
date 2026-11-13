<?php
    $mensaje = "";
    $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

    if (!$conexion) {
        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    }

    session_start();
    if (isset($_SESSION['usuario'])) {
        $correo = $_SESSION['usuario'];

        $sqlUsuario = "SELECT id FROM registro WHERE email = '$correo'";
        $resultadoUsuario = mysqli_query($conexion, $sqlUsuario);

        if ($resultadoUsuario && mysqli_num_rows($resultadoUsuario) > 0) {
            $filaUsuario = mysqli_fetch_assoc($resultadoUsuario);
            $mi_id = $filaUsuario['id'];
        } else {
            die("No se pudo obtener la ID del usuario.");
        }

        $sqlSolicitudes = "
            SELECT s.id_solicitud, r.id AS solicitante_id, r.fotoperfil, r.nombre, r.apellidos, r.email
            FROM solicitudes_amistad s
            JOIN registro r ON s.solicitante_id = r.id
            WHERE s.solicitado_id = '$mi_id' AND s.estado = 'pendiente'
        ";
        $resultado = mysqli_query($conexion, $sqlSolicitudes);

        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }
    }

    if (isset($_POST['accion'])) {
        $id_solicitud = $_POST['id_solicitud'];
        $solicitante_id = $_POST['solicitante_id'];
        $accion = $_POST['accion'];

        if ($accion === 'aceptar') {
            $sqlInsertarAmigo = "INSERT INTO amigos (mi_id, id_amigo, fotoperfil, nombre, apellidos)
                                SELECT '$mi_id', r.id, r.fotoperfil, r.nombre, r.apellidos
                                FROM registro r
                                WHERE r.id = '$solicitante_id'";

            if (mysqli_query($conexion, $sqlInsertarAmigo)) {
                $sqlActualizarSolicitud = "UPDATE solicitudes_amistad SET estado = 'aceptada' WHERE id_solicitud = '$id_solicitud'";
                mysqli_query($conexion, $sqlActualizarSolicitud);
                $mensaje = "Solicitud de amistad aceptada.";
            } else {
                $mensaje = "Error al aceptar la solicitud: " . mysqli_error($conexion);
            }

        } elseif ($accion === 'rechazar') {

            $sqlRechazarSolicitud = "UPDATE solicitudes_amistad SET estado = 'rechazada' WHERE id_solicitud = '$id_solicitud'";
            if (mysqli_query($conexion, $sqlRechazarSolicitud)) {
                $mensaje = "Solicitud de amistad rechazada.";
            } else {
                $mensaje = "Error al rechazar la solicitud: " . mysqli_error($conexion);
            }
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
    <link rel="stylesheet" href="../css/misamigos1.css">
    <title>Solicitudes de Amistad</title>
</head>
<body>
    <header>
        <nav>
            <center>
                <ul>
                    <li><a href="miperfil.php"><img src="../Imagenes/usuarioNO.png" alt="perfil" class="imagen"><br>Mi Perfil</a></li>
                    <li><a href="misamigos.php"><img src="../Imagenes/amigosNO.png" alt="amigos" class="imagen"><br>Mis Amigos</a></li>
                    <li><a href="misfotos.php"><img src="../Imagenes/fotosNO.png" alt="fotos" class="imagen"><br>Mis Fotos</a></li>
                    <li><a href="buscaramigos.php"><img src="../Imagenes/buscarNO.png" alt="buscaramigos" class="imagen"><br>Buscar Amigos</a></li>
                    <li><a href="#"><img src="../Imagenes/solicitudesNO.png" alt="soli" class="imagen"><br>Solicitudes</a></li>
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
                        $id_solicitud = $fila['id_solicitud'];
                        $solicitante_id = $fila['solicitante_id'];
                        $fotoperfil = $fila['fotoperfil'];
                        $nombre = $fila['nombre'];
                        $apellidos = $fila['apellidos'];
                        $email = $fila['email'];

                        echo "<div class='contenedor'>";
                        echo "<img src='$fotoperfil' alt='Foto de $nombre' class='fotoperfil'>";
                        echo "<p>$nombre $apellidos</p>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='id_solicitud' value='$id_solicitud'>";
                        echo "<input type='hidden' name='solicitante_id' value='$solicitante_id'>";
                        echo "<button type='submit' name='accion' value='aceptar'>Aceptar</button>";
                        echo "<button type='submit' name='accion' value='rechazar'>Rechazar</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No tienes solicitudes pendientes.</p>";
                }

                if (isset($conexion)) {
                    mysqli_close($conexion);
                }
            ?>
        </section>
    </main>
</body>
</html>
