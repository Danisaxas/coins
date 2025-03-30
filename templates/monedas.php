<?php
// templates/monedas.php
// Ya no es necesario llamar a session_start() aquí
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?page=login"); // Redirige si no hay sesión
    exit();
}
if ($_SESSION['ban'] == 1){
    echo "Usuario Baneado";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Monedas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen bg-black">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Sistema de Monedas</h2>
        <p class="text-gray-700 text-center mb-4">Bienvenido, <?php echo $_SESSION['username']; ?>!</p>
        <p class="text-gray-700 text-center mb-6">Tienes <strong><?php echo $_SESSION['monedas']; ?></strong> monedas.</p>
        <?php if($_SESSION['username'] === 'AstroOwn'): ?>
        <div class="mt-4">
            <a href="index.php?page=admin_codes" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full text-center">
                OWNER
            </a>
        </div>
        <?php endif; ?>
        <a href="index.php?page=logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full mt-4">Cerrar Sesión</a>
    </div>
</body>
</html>