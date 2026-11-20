CREATE DATABASE IF NOT EXISTS devtrack_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE devtrack_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email_lider VARCHAR(150) NOT NULL,
    tecnologia VARCHAR(50) NOT NULL,
    repo_publico TINYINT(1) DEFAULT 0,
    progreso INT DEFAULT 0,
    estado TINYINT(1) DEFAULT 1,
    usuario_id INT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

INSERT INTO usuarios (nombre, email, password) 
VALUES ('Administrador', 'admin@devtrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
