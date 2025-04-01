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
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-white/10 p-8 rounded-xl shadow-lg backdrop-blur-md w-full max-w-md">
        <div class="flex justify-between items-start mb-4">
             <?php if (isset($_SESSION['usuario_id']) && $_SESSION['username'] === 'AstroOwn'): ?>
            <a href="index.php?page=admin_codes" class="bg-blue-500/20 border border-blue-400 text-blue-300 font-semibold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300 ease-in-out hover:scale-105 text-left">
                Terminal </>
            </a>
            <?php endif; ?>           
             <a href="index.php?page=logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-right">Cerrar Sesión</a>
        </div>
        <h2 class="text-3xl font-semibold text-white mb-6 text-center">Sistema de Monedas</h2>
        <p class="text-gray-400 text-center mb-4">Bienvenido, <?php echo $_SESSION['username']; ?>!</p>
        <p class="text-gray-400 text-center mb-6">Tienes <strong><?php echo $_SESSION['monedas']; ?></strong> monedas.</p>

        <div class="mb-4">
            <label for="codigo" class="block text-gray-300 text-sm font-bold mb-2">Código:</label>
            <input type="text" id="codigo" name="codigo" placeholder="Ingresa tu código" class="shadow appearance-none border border-white/20 rounded-md w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white/50 placeholder:text-gray-500">
        </div>

        <button id="canjear" class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out hover:scale-105">Canjear</button>

        <div id="mensaje" class="mt-6 text-gray-400 text-center"></div>

       
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
                fetch('actualizar_monedas.php', {  // Crear un nuevo archivo para manejar esto
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `monedas=${monedas}`,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al actualizar las monedas');
                    }
                    return response.text(); // O response.json() si el servidor devuelve JSON
                })
                .then(data => {
                    console.log(data); // Puedes hacer algo con la respuesta del servidor
                })
                .catch(error => {
                    console.error('Error:', error);
                    mensaje.textContent = "Error al actualizar las monedas. Por favor, intenta de nuevo.";
                    mensaje.style.color = "red";
                });

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
