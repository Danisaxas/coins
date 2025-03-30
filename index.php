<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier otra salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'home', 'logout', 'monedas', 'admin_codes'];

// Obtiene la ruta desde la URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Output buffering
ob_start(); // Iniciar el búfer de salida

// Incluye el template correspondiente
if ($page === 'register') {
    include 'templates/register.php';
} elseif ($page === 'login') {
    include 'templates/login.php';
} elseif ($page === 'home') {
    // Verificar si el usuario ha iniciado sesión antes de mostrar la página de monedas
    if (isset($_SESSION['usuario_id'])) {
        include 'templates/monedas.php';
    } else {
        // Redirige al usuario al login si no está logueado
        $pageToLoad = 'login'; // Establecer la página a cargar
    }
} elseif ($page === 'logout') {
    include 'templates/logout.php';
} elseif ($page === 'admin_codes') {
    // Verificar si el usuario es un OWNER
    if (isset($_SESSION['usuario_id']) && $_SESSION['username'] === 'AstroOwn') {
        include 'templates/admin_codes.php';
    } else {
        $pageToLoad = 'home'; // Establecer la página a cargar
    }
} else {
    // Manejar página no encontrada
    echo "Página no encontrada"; // Puedes crear una página 404 personalizada
}

// Redirigir después de procesar la lógica principal
if (isset($pageToLoad)) {
    header("Location: index.php?page=" . $pageToLoad);
    exit();
}

ob_end_flush(); // Enviar la salida del búfer
?>
