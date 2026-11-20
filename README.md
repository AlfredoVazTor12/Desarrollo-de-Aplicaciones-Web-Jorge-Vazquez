# DevTrack | Sistema de Gestión de Proyectos y Repositorios

**DevTrack** es una aplicación web desarrollada en **PHP, MySQL, JavaScript (Vanilla + SweetAlert2) y CSS3**, diseñada para administrar proyectos de desarrollo de software. El sistema implementa operaciones completas de **CRUD**, **autenticación de usuarios** y **control de sesiones** para proteger el acceso a los módulos internos.

---

## Características Principales

* **Autenticación y Sesiones:** Inicio y cierre de sesión seguro con contraseñas encriptadas (`password_hash`) y protección de rutas mediante `auth_guard.php`.
* **CREATE (Registrar):** Creación de nuevos proyectos con validación tanto en cliente (JS) como en servidor (PHP).
* **READ (Consultar):** Visualización en tiempo real de proyectos activos en tablas dinámicas y cálculo automático de métricas en reportes.
* **UPDATE (Modificar):** Edición rápida de nombre, tecnología y porcentaje de avance mediante ventanas modales interactivas.
* **DELETE (Desactivar):** Implementación de **borrado lógico (Soft Delete)** mediante el campo `estado`, permitiendo desactivar proyectos sin perder su registro histórico en las estadísticas.

---

## Requisitos Previos

Para ejecutar este proyecto en un entorno local necesitas tener instalado un servidor web con soporte para PHP y MySQL, como:
* **XAMPP** / **WAMP** / **Laragon** / **MAMP**
* **PHP** 7.4 o superior (con extensión `pdo_mysql` habilitada)
* **MySQL** 5.7+ o **MariaDB**

---

## Estructura del Proyecto

```text
devtrack/
├── api/                          # Controladores Backend (Endpoints JSON)
│   ├── crear_proyecto.php        # CREATE
│   ├── actualizar_proyecto.php   # UPDATE
│   └── eliminar_proyecto.php     # DELETE (Soft Delete)
├── assets/                       # Archivos estáticos
│   ├── css/style.css             # Hoja de estilos
│   └── js/script.js              # Lógica frontend, calculadora y peticiones Fetch
├── config/
│   └── conexion.php              # Configuración de conexión PDO a MySQL
├── includes/
│   ├── auth_guard.php            # Middleware de protección de sesiones
│   └── sidebar.php               # Menú lateral reutilizable
├── sql/
│   └── devtrack_db.sql           # Script SQL de creación de tablas y datos iniciales
├── index.php                     # Dashboard General (Formulario CREATE + Calculadora)
├── repositorios.php              # Gestión de Proyectos (Tabla READ + UPDATE/DELETE)
├── reportes.php                  # Reportes y estadísticas dinámicas
├── login.php                     # Pantalla de inicio de sesión
└── logout.php                    # Cierre y destrucción de sesión
```

---

## Guía de Instalación

### 1. Ubicar los archivos en el servidor local
Copia la carpeta `devtrack/` dentro del directorio público de tu servidor local:
* **XAMPP:** `C:\xampp\htdocs\devtrack`
* **Laragon:** `C:\laragon\www\devtrack`
* **MAMP:** `/Applications/MAMP/htdocs/devtrack`

### 2. Crear la Base de Datos
1. Inicia los servicios de **Apache** y **MySQL** en tu panel de control.
2. Abre **phpMyAdmin** (`http://localhost/phpmyadmin`) o tu cliente SQL preferido.
3. Importa el archivo `sql/devtrack_db.sql` o ejecuta el siguiente script SQL:

```sql
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

-- Usuario administrador por defecto (Contraseña: admin123)
INSERT INTO usuarios (nombre, email, password) 
VALUES ('Administrador', 'admin@devtrack.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```

### 3. Configurar la Conexión
Abre el archivo `config/conexion.php` y verifica que las credenciales coincidan con tu servidor MySQL:

```php
$host = 'localhost';
$db   = 'devtrack_db';
$user = 'root';
$pass = ''; // Coloca tu contraseña si tu MySQL tiene una configurada
```

### 4. Ejecutar la Aplicación
Abre tu navegador web e ingresa a:
```text
http://localhost/devtrack/login.php
```

---

## Credenciales de Acceso (Prueba)

Utiliza el usuario precargado en la base de datos para ingresar al sistema:

* **Correo Electrónico:** `admin@devtrack.com`
* **Contraseña:** `admin123`

---

## 📖 Manual de Uso

1. **Inicio de Sesión (`login.php`):**
   * Ingresa tus credenciales. Si intentas acceder directamente a `index.php`, `repositorios.php` o `reportes.php` sin iniciar sesión, el sistema te redirigirá automáticamente al login.
2. **Registrar un Proyecto (`index.php`):**
   * Completa el formulario *Registrar Nuevo Proyecto* indicando el nombre (mínimo 4 caracteres), correo válido del líder técnico, tecnología principal y marca la casilla de repositorio público.
   * Haz clic en **Guardar Proyecto** para almacenarlo en la base de datos.
   * *Extra:* Puedes utilizar la calculadora integrada en el panel derecho para estimaciones rápidas.
3. **Consultar, Editar y Desactivar (`repositorios.php`):**
   * Visualiza todos los proyectos activos en la tabla principal.
   * **Editar:** Haz clic en el botón **Editar** para abrir un modal donde podrás modificar el nombre, la tecnología o actualizar el porcentaje de progreso (`0%` a `100%`). Al llegar al `100%`, el estado cambiará automáticamente a `COMPLETADO`.
   * **Desactivar:** Haz clic en **Desactivar** para ocultar el proyecto de la lista activa (borrado lógico).
4. **Visualizar Estadísticas (`reportes.php`):**
   * Consulta las barras de progreso individuales de cada proyecto activo y el resumen general (total de activos, completados, promedio global de avance y proyectos desactivados).
5. **Cerrar Sesión (`logout.php`):**
   * Haz clic en el botón **Cerrar Sesión** en la barra superior derecha para destruir la sesión activa de forma segura.
