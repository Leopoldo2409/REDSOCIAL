<?php
    $mensaje = "";
    $conexion = mysqli_connect("localhost", "root", "", "base_de_datos");

    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
        $archivo = $_FILES['archivo'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
    
        // Validar y mover la imagen al servidor
        $nombreArchivo = time() . "_" . basename($archivo['name']);
        $directorioDestino = "uploads/" . $nombreArchivo;
    
        if (move_uploaded_file($archivo['tmp_name'], $directorioDestino)) {
            // Insertar información en la base de datos
            $stmt = $conexion->prepare("INSERT INTO fotos (nombre, descripcion, estado) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombreArchivo, $descripcion, $estado);
            $stmt->execute();
    
            echo "Foto subida con éxito!";
        } else {
            echo "Error al subir la foto.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/misfotos.css">
    <title>Mis fotos</title>
</head>
<body>
    <header>
        <nav><center>
            <ul>
                <li><a href="miperfil.php"><img src="../Imagenes/usuarioNO.png" alt="perfil" class="imagen"><br>Mi Perfil</a></li><br>
                <li><a href="misamigos.php"><img src="../Imagenes/amigosNO.png" alt="amigos" class="imagen"><br>Mis Amigos</a></li><br>
                <li><a href="#"><img src="../Imagenes/fotosNO.png" alt="fotos" class="imagen"><br>Mis Fotos</a></li><br>
                <li><a href="buscaramigos.php"><img src="../Imagenes/buscarNO.png" alt="buscaramigos" class="imagen"><br>Buscar Amigos</a></li><br>
                <li><a href="solicitud.php"><img src="../Imagenes/solicitudesNO.png" alt="soli" class="imagen"><br>Solicitudes</a></li><br>
                <li><a href="cerrarsesion.php"><img src="../Imagenes/cerrarNo.png" alt="cerrar" class="imagen"><br>Cerrar Sesión</a></li><br>
            </ul></center>
        </nav>
    </header>
    <main>
        <section class="seccion">
            <center>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <p>
                 <label for="archivo">Seleccionar imagen:</label>
                 <input type="file" name="archivo" required>
                 </p>
                 <p>
                 <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" required></textarea>
                    </p>
                    <p>
                    <label for="estado">Estado:</label>
                        <select name="estado">
                        <option value="publica">Pública</option>
                        <option value="privada">Privada</option>
                     </select>
                     </p>
                     <p>
                         <button type="submit" name="btnsubirfotos">Subir Foto</button>
                         </p>
        </form>
        </center>
        </section>
    </main>
</body>
</html>