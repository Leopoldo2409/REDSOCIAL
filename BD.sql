CREATE DATABASE IF NOT EXISTS base_de_datos;

USE base_de_datos;

CREATE TABLE registro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    descripcion TEXT NOT NULL,
    pass VARCHAR(255) NOT NULL,
    fotoperfil VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE solicitudes_amistad (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    solicitante_id INT NOT NULL,
    solicitado_id INT NOT NULL,
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (solicitante_id) REFERENCES registro(id) ON DELETE CASCADE,
    FOREIGN KEY (solicitado_id) REFERENCES registro(id) ON DELETE CASCADE
);

CREATE TABLE amigos (
    mi_id INT NOT NULL,
    id_amigo INT NOT NULL,
    fotoperfil VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    PRIMARY KEY (mi_id, id_amigo),
    FOREIGN KEY (mi_id) REFERENCES registro(id) ON DELETE CASCADE,
    FOREIGN KEY (id_amigo) REFERENCES registro(id) ON DELETE CASCADE
);

CREATE TABLE fotos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT,
  estado ENUM('publica', 'privada') DEFAULT 'privada',
  fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP
);