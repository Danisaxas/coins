php
<?php
// index.php
session_start(); // Inicia la sesión al principio de index.php
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Determina qué página cargar
$page = isset($_GET['page']) ? $_GET['page'] : 'register'; // Por defecto a la página de registro

if ($page === 'register') {
    include 'templates/register.php';
} elseif ($page === 'login') {
    include 'templates/login.php';
} elseif ($page === 'monedas') {
    include 'templates/monedas.php';
} elseif ($page === 'logout') {
    include 'templates/logout.php';
} else {
    // Manejar página no encontrada
    echo "Página no encontrada"; // Puedes crear una página 404 personalizada
}
?>