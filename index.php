<?php
// index.php
// Asegúrate de que session_start() esté al principio del archivo, antes de cualquier otra salida
session_start();
require_once 'db/system_user.php'; // Incluye el archivo de la base de datos

// Define un array con las rutas permitidas
$rutasPermitidas = ['register', 'login', 'chat', 'logout', 'shell']; // Usa 'shell' en lugar de 'admin_codes' y 'chat' en lugar de 'monedas'

// Obtiene la ruta desde la URL
$page = isset($_GET['page']) ? $_GET['page'] : 'chat'; // Página por defecto a la página de chat

// Output buffering
ob_start();

// Determina a qué página ir
if (isset($_SESSION['usuario_id'])) {
    // Si el usuario tiene una sesión iniciada
    if ($page === 'register' || $page === 'login') {
        // Redirige al usuario a la página de chat
        header("Location: index.php?page=chat");
        exit();
    } elseif ($page === 'logout') {
        include 'templates/logout.php';
    } elseif ($page === 'shell') { // Usa 'shell' en lugar de 'admin_codes'
        // Verificar si el usuario es un OWNER
        if ($_SESSION['username'] === 'AstroOwn') {
            include 'templates/shell.php'; // Incluye shell.php
        } else {
            header("Location: index.php?page=chat");
            exit();
        }
    } else {
        include 'templates/chat.php'; // Muestra la página de chat
    }
} else {
    // Si el usuario no tiene una sesión iniciada
    include 'templates/login.php';
}

ob_end_flush();
?>
