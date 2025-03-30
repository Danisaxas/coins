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
<body class="bg-gray-900  min-h-screen ">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-start mb-4">
             <?php if (isset($_SESSION['usuario_id']) && $_SESSION['username'] === 'AstroOwn'): ?>
            <a href="index.php?page=admin_codes" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline  text-left">
                OWNER
            </a>
            <?php endif; ?>           
             <a href="index.php?page=logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-right">Cerrar Sesión</a>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-md  max-w-md mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Sistema de Monedas</h2>
        <p class="text-gray-300 text-center mb-4">Bienvenido, <?php echo $_SESSION['username']; ?>!</p>
        <p class="text-gray-300 text-center mb-6">Tienes <strong><?php echo $_SESSION['monedas']; ?></strong> monedas.</p>

        <div class="mb-4">
            <label for="codigo" class="block text-gray-700 text-sm font-bold mb-2">Código:</label>
            <input type="text" id="codigo" name="codigo" placeholder="Ingresa tu código" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <button id="canjear" class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Canjear</button>

        <div id="mensaje" class="mt-4 text-gray-600 text-center"></div>

       </div>
    </div>

    <script>
        const monedasSpan = document.getElementById("monedas");
        const codigoInput = document.getElementById("codigo");
        const canjearButton = document.getElementById("canjear");
        const mensaje = document.getElementById("mensaje");


        let monedas = <?php echo $_SESSION['monedas']; ?>; // Inicializa con las monedas de la sesión
        let codigoCanjeado = false; // Variable para rastrear si el código ya se canjeó

        canjearButton.addEventListener("click", () => {
            const codigo = codigoInput.value.toUpperCase();
            if (codigo === "UNITY" && !codigoCanjeado) {
                monedas += 100;
                monedasSpan.textContent = `Monedas: ${monedas}`;
                mensaje.textContent = "¡Código canjeado con éxito! Se han añadido 100 monedas.";
                mensaje.style.color = "green";
                codigoCanjeado = true;
                // Actualizar las monedas en la sesión (esto es importante)
                <?php $_SESSION['monedas'] ?> = monedas;
                 // Deshabilitar el botón después de canjear
                canjearButton.disabled = true;
                codigoInput.disabled = true;

            } else if (codigo === "") {
                mensaje.textContent = "Por favor, ingresa un código.";
                mensaje.style.color = "red";
            } else if (codigo === "UNITY" && codigoCanjeado) {
                mensaje.textContent = "El código ya ha sido canjeado.";
                mensaje.style.color = "red";
            }else {
                mensaje.textContent = "Código inválido. Por favor, intenta de nuevo.";
                mensaje.style.color = "red";
            }
            codigoInput.value = "";
        });

    </script>
</body>
</html>
