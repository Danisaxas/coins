<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier otra salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'monedas', 'logout', 'admin_codes'];

// Obtiene la ruta desde la URL
$page = isset($_GET['page']) ? $_GET['page'] : 'monedas'; // Página por defecto a la página de monedas

// Verifica si la ruta está permitida
if (!in_array($page, $rutasPermitidas)) {
    $page = 'login'; // Si no es válida, usa 'login' como fallback
}

// Output buffering
ob_start();

// Incluye el template correspondiente
if ($page === 'register') {
    include 'templates/register.php';
} elseif ($page === 'login') {
    include 'templates/login.php';
} elseif ($page === 'monedas') {
    // Verificar si el usuario ha iniciado sesión antes de mostrar la página de monedas
    if (isset($_SESSION['usuario_id'])) {
        include 'templates/monedas.php';
    } else {
        // Redirige al usuario al login si no está logueado
        header("Location: index.php?page=login"); // Redirige a index.php?page=login
        exit();
    }
} elseif ($page === 'logout') {
    include 'templates/logout.php';
} elseif ($page === 'admin_codes') { // Agrega el manejo de la nueva página
    // Verificar si el usuario es un OWNER
    if (isset($_SESSION['usuario_id']) && $_SESSION['username'] === 'AstroOwn') {
        include 'templates/admin_codes.php';
    } else {
        // Redirigir a una página de error o a la página principal
        header("Location: index.php?page=monedas");
        exit();
    }
} else {
    // Manejar página no encontrada
    echo "Página no encontrada"; // Puedes crear una página 404 personalizada
}

ob_end_flush();
?>
