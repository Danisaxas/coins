<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'home', 'logout'];

// Obtiene la ruta desde la URL
$ruta = isset($_GET['page']) ? $_GET['page'] : 'home'; // La página principal será 'home'

// Output buffering
ob_start();

// Incluye el template correspondiente
if ($ruta === 'register') {
    include 'templates/register.php';
} elseif ($ruta === 'login') {
    include 'templates/login.php';
} elseif ($ruta === 'home') {
    // Verificar si el usuario ha iniciado sesión antes de mostrar la página de monedas
    if (isset($_SESSION['usuario_id'])) {
        include 'templates/monedas.php';
    } else {
        // Redirige al usuario al login si no está logueado
        header("Location: index.php?page=login"); // Redirige a /login
        exit();
    }
} elseif ($ruta === 'logout') {
    include 'templates/logout.php';
} else {
    // Manejar página no encontrada
    echo "Página no encontrada"; // Puedes crear una página 404 personalizada
}

ob_end_flush();
?>
