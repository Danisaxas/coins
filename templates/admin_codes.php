<?php
// templates/admin_codes.php
if (!isset($_SESSION['usuario_id']) || $_SESSION['username'] !== 'AstroOwn') {
    header("Location: index.php?page=home"); // Redirige si no es el OWNER
    exit();
}

require_once(__DIR__ . '/../db/system_user.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $recompensa = $_POST['recompensa'];
    $creada_por = $_SESSION['username']; // Obtiene el username del OWNER

    $resultado_creacion = crearCodigo($pdo, $codigo, $recompensa, $creada_por);

    if ($resultado_creacion === true) {
        echo "<p class='text-green-500 text-sm mt-2 text-center'>Código creado con éxito.</p>";
    } else {
        echo "<p class='text-red-500 text-sm mt-2 text-center'>$resultado_creacion</p>";
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
<body class="bg-gray-100 flex items-center justify-center min-h-screen bg-black">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Administración de Códigos</h1>

        <form method="post" action="index.php?page=admin_codes">
            <div class="mb-4">
                <label for="codigo" class="block text-gray-700 text-sm font-bold mb-2">Código:</label>
                <input type="text" id="codigo" name="codigo" placeholder="Ingrese el código" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="recompensa" class="block text-gray-700 text-sm font-bold mb-2">Recompensa:</label>
                <input type="number" id="recompensa" name="recompensa" placeholder="Ingrese la recompensa" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Crear Código</button>
        </form>
        <a href="index.php?page=home" class="mt-4 text-center text-blue-500 hover:text-blue-700 font-semibold block">Volver a Monedas</a>
    </div>
</body>
</html>