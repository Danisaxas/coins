<?php
// templates/admin_codes.php
if (!isset($_SESSION['usuario_id']) || $_SESSION['username'] !== 'AstroOwn') {
    header("Location: index.php?page=home");
    exit();
}

require_once(__DIR__ . '/../db/system_user.php'); // Corrige la ruta al archivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $recompensa = $_POST['recompensa'];
    $creada_por = $_SESSION['username'];

    $resultado_creacion = crearCodigo($pdo, $codigo, $recompensa, $creada_por);

    if ($resultado_creacion === true) {
        echo "<div class='bg-green-500/20 border border-green-400 text-green-300 p-4 rounded-md mb-4 text-center' role='alert'>
                <strong class='font-bold'>Éxito:</strong>
                <span class='block sm:inline'>Código creado con éxito.</span>
            </div>";
    } else {
        echo "<div class='bg-red-500/20 border border-red-400 text-red-300 p-4 rounded-md mb-4 text-center' role='alert'>
                <strong class='font-bold'>Error:</strong>
                <span class='block sm:inline'>$resultado_creacion</span>
            </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Códigos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-white/10 p-8 rounded-xl shadow-lg backdrop-blur-md w-full max-w-md">
        <h1 class="text-3xl font-semibold text-white mb-6 text-center">Administración de Códigos</h1>

        <form method="post" action="index.php?page=admin_codes" class="space-y-6">
            <div>
                <label for="codigo" class="block text-gray-300 text-sm font-bold mb-2">Código:</label>
                <input type="text" id="codigo" name="codigo" placeholder="Ingrese el código" required class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
            </div>
            <div>
                <label for="recompensa" class="block text-gray-300 text-sm font-bold mb-2">Recompensa:</label>
                <input type="number" id="recompensa" name="recompensa" placeholder="Ingrese la recompensa" required class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
            </div>
            <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out hover:scale-105">Crear Código</button>
        </form>
        <div class="mt-8 text-center">
            <a href="index.php?page=home" class="text-blue-400 hover:text-blue-300 font-semibold transition duration-200 ease-in-out">Volver a Monedas</a>
        </div>
    </div>
</body>
</html>
