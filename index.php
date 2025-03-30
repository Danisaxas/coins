<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier salida
session_start();
// Incluye el archivo de la base de datos
$db_file_path = __DIR__ . '/db/system_user.php'; // Define la ruta absoluta al archivo
if (file_exists($db_file_path)) {
    require_once $db_file_path;
} else {
    die("Error: No se pudo encontrar el archivo de la base de datos en: " . $db_file_path);
}

// Determina qué página cargar
$page = isset($_GET['page']) ? $_GET['page'] : 'register'; // Por defecto a la página de registro

// Output buffering is used to prevent el error "headers already sent".
ob_start();

if ($page === 'register') {
    include 'templates/register.php';
} elseif ($page === 'login') {
    include 'templates/login.php';
} elseif ($page === 'monedas') {
    // Verificar si el usuario ha iniciado sesión antes de mostrar la página de monedas
    if (isset($_SESSION['usuario_id'])) {
        include 'templates/monedas.php';
    } else {
        // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
        header("Location: index.php?page=login");
        exit();
    }
} elseif ($page === 'logout') {
    include 'templates/logout.php';
} else {
    // Manejar página no encontrada
    echo "Página no encontrada"; // Puedes crear una página 404 personalizada
}

ob_end_flush();
?>
