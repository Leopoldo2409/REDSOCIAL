<?php
    $mensaje = "";
    $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

    session_start();
    $correo = $_SESSION['usuario'];

    $sql = "SELECT * FROM registro WHERE email = '{$correo}'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila['nombre'];
        $apellidos = $fila['apellidos'];
        $edad = $fila['edad'];
        $descripcion = $fila['descripcion'];
        $direccion = $fila['fotoperfil'];
    } else {
        echo "No se encontró el usuario.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnGuardar'])) {
        $nuevoNombre = $_POST['nombre'];
        $nuevosApellidos = $_POST['apellidos'];
        $nuevaEdad = $_POST['edad'];
        $fotoPerfil = $_FILES['fotoPerfil']['name'];

        if (!empty($fotoPerfil)) {
            $ruta = "../fotodeperfil/" . basename($fotoPerfil);
            if (move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $ruta)) {
                $direccion = $ruta;
            }
        }

        $sqlActualizar = "UPDATE registro SET 
            nombre = '{$nuevoNombre}', 
            apellidos = '{$nuevosApellidos}', 
            edad = '{$nuevaEdad}', 
            fotoperfil = '{$direccion}' 
            WHERE email = '{$correo}'";

        mysqli_query($conexion, $sqlActualizar);

    }

    function foto_perfil($direccion)
    {
        if ($direccion !== "../fotodeperfil/") {
            return "<img src='{$direccion}' alt='Foto de perfil' class='imgusuario'>";
        } else {
            return "<img src='../Imagenes/usuarioNo.png' alt='Foto de perfil' class='imgusuario'>";
        }
    }

    mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Imagenes/coyote1.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/miperfil1.css">
    <title>Mi Perfil</title>
    <script>
        function formulario() {
            const formulario = document.getElementById("formularioEditar");
            formulario.style.display = formulario.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <header>
        <nav><center>
            <ul>
                <li><a href="#"><img src="../Imagenes/usuarioNO.png" alt="perfil" class="imagen"><br>Mi Perfil</a></li><br>
                <li><a href="misamigos.php"><img src="../Imagenes/amigosNO.png" alt="amigos" class="imagen"><br>Mis Amigos</a></li><br>
                <li><a href="misfotos.php"><img src="../Imagenes/fotosNO.png" alt="fotos" class="imagen"><br>Mis Fotos</a></li><br>
                <li><a href="buscaramigos.php"><img src="../Imagenes/buscarNO.png" alt="buscaramigos" class="imagen"><br>Buscar Amigos</a></li><br>
                <li><a href="solicitud.php"><img src="../Imagenes/solicitudesNO.png" alt="soli" class="imagen"><br>Solicitudes</a></li><br>
                <li><a href="cerrarsesion.php"><img src="../Imagenes/cerrarNo.png" alt="cerrar" class="imagen"><br>Cerrar Sesión</a></li><br>
            </ul></center>
        </nav>
    </header>
    <main>
        <center>
            <section class="miPerfil">
                <?php
                    echo foto_perfil($direccion);
                    echo "<p>Nombre: {$nombre} {$apellidos}</p>";
                    echo "<p>Edad: {$edad}</p>";
                    echo "<p>Descripcion: {$descripcion}</p>";
                ?>
                <button onclick="formulario()">Editar Perfil</button>
            <section id="formularioEditar" style="display: none;">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required><br>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" name="apellidos" id="apellidos" value="<?php echo $apellidos; ?>" required><br>
                    <label for="edad">Edad:</label>
                    <input type="number" name="edad" id="edad" value="<?php echo $edad; ?>" required><br>
                    <label for="fotoPerfil">Foto de Perfil:</label>
                    <input type="file" name="fotoPerfil" id="fotoPerfil"><br>
                    <button type="submit" name="btnGuardar">Guardar Cambios</button>
                </form>
            </section>            
            </section>
            <img src="../Imagenes/a.png" alt="a" class="coyotito">
        </center>
    </main>
</body>
</html>
