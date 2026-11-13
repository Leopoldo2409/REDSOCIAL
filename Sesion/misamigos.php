<?php
$conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

session_start();
if (isset($_SESSION['usuario'])) {
    $correo = $_SESSION['usuario'];
    $sql = "SELECT id FROM registro WHERE email = '$correo'";
    $resultado = mysqli_query($conexion, $sql);
    $usuario = mysqli_fetch_assoc($resultado);
    $mi_id = $usuario['id'];

    // Obtener amigos
    $sqlAmigos = "
        SELECT a.id_amigo, r.nombre, r.apellidos, r.fotoperfil 
        FROM amigos a
        INNER JOIN registro r ON a.id_amigo = r.id
        WHERE a.mi_id = $mi_id";
    $resultadoAmigos = mysqli_query($conexion, $sqlAmigos);

} else {
    echo "No hay usuario en sesión.";
    exit();
}

// Eliminar amistad
if (isset($_POST['btnEliminar'])) {
    $id_amigo = $_POST['id_amigo'];

    // Eliminar de ambas direcciones
    $sqlEliminar = "DELETE FROM amigos WHERE (mi_id = $mi_id AND id_amigo = $id_amigo) OR (mi_id = $id_amigo AND id_amigo = $mi_id)";
    mysqli_query($conexion, $sqlEliminar);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Aceptar solicitud de amistad (ejemplo)
if (isset($_POST['btnAceptar'])) {
    $id_solicitante = $_POST['id_solicitante'];

    // Insertar relación bidireccional en la tabla de amigos
    $sqlAceptar = "INSERT INTO amigos (mi_id, id_amigo, fotoperfil, nombre, apellidos)
                   SELECT $mi_id, id, fotoperfil, nombre, apellidos
                   FROM registro WHERE id = $id_solicitante";
    mysqli_query($conexion, $sqlAceptar);

    $sqlAceptarInverso = "INSERT INTO amigos (mi_id, id_amigo, fotoperfil, nombre, apellidos)
                          SELECT id, $mi_id, fotoperfil, nombre, apellidos
                          FROM registro WHERE id = $mi_id";
    mysqli_query($conexion, $sqlAceptarInverso);

    // Actualizar la solicitud de amistad
    $sqlActualizarSolicitud = "UPDATE solicitudes_amistad SET estado = 'aceptada' WHERE solicitante_id = $id_solicitante AND solicitado_id = $mi_id";
    mysqli_query($conexion, $sqlActualizarSolicitud);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigos</title>
    <link rel="stylesheet" href="../css/misamigos1.css">
</head>
<body>
    <header>
        <nav>
            <center>
                <ul>
                    <li><a href="miperfil.php"><img src="../Imagenes/usuarioNO.png" alt="perfil" class="imagen"><br>Mi Perfil</a></li><br>
                    <li><a href="#"><img src="../Imagenes/amigosNO.png" alt="amigos" class="imagen"><br>Mis Amigos</a></li><br>
                    <li><a href="misfotos.php"><img src="../Imagenes/fotosNO.png" alt="fotos" class="imagen"><br>Mis Fotos</a></li><br>
                    <li><a href="buscaramigos.php"><img src="../Imagenes/buscarNO.png" alt="buscaramigos" class="imagen"><br>Buscar Amigos</a></li><br>
                    <li><a href="solicitud.php"><img src="../Imagenes/solicitudesNO.png" alt="soli" class="imagen"><br>Solicitudes</a></li><br>
                    <li><a href="cerrarsesion.php"><img src="../Imagenes/cerrarNo.png" alt="cerrar" class="imagen"><br>Cerrar Sesión</a></li><br>
                </ul>
            </center>
        </nav>
    </header>
    <main>
        <section class="seccion">
            <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        $id_amigo = $fila['id_amigo'];
                        $fotoperfil = $fila['fotoperfil'];
                        $nombre = $fila['nombre'];
                        $apellidos = $fila['apellidos'];

                        echo "<div class='contenedor'>";
                        echo "<form method='POST'>";
                        echo "<img src='$fotoperfil' alt='Foto de $nombre' class='fotoperfil'>";
                        echo "<p>$nombre $apellidos</p>";
                        echo "<button type='submit' class='boton' name='btnEliminar' value='$id_amigo'>Borrar</button>";
                        echo "<button type='submit' class='boton' name='btnEliminar' value='$id_amigo'>Ver Perfil</button>";
                        echo "<button type='submit' class='boton' name='btnEliminar' value='$id_amigo'>Ver Fotos</button>";
                        echo "<input type='hidden' name='id_amigo' value='$id_amigo'>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No se encontraron amigos para este usuario</p>";
                }
            ?>
        </section>
        <img src="../Imagenes/a.png" alt="a" class="coyotito">
    </main>
</body>
</html>