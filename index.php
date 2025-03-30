<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canje de Códigos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/canvas-confetti@1.9.0/dist/confetti.browser.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }
    </style>
</head>
<body class="bg-black flex items-center justify-center min-h-screen">
    <canvas id="confetti-canvas"></canvas>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md relative z-10">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Canjea tu Código</h1>
        <div class="flex items-center mb-4">
            <img src="https://img.freepik.com/psd-gratis/simbolo-loteria-realista-aislado_23-2151177245.jpg?t=st=1743336502~exp=1743340102~hmac=d0ab6a4692f1204b707647b7e6fabb1ae407324b13af0773481ea1ccfc195857&w=740" alt="Icono de Moneda" class="mr-2 w-6 h-6">
            <span id="monedas" class="text-gray-700 font-medium">Monedas: <?php echo isset($_SESSION['monedas']) ? $_SESSION['monedas'] : 0; ?></span>
        </div>
        <form method="post" action="">
            <div class="mb-4">
                <label for="codigo" class="block text-gray-700 text-sm font-bold mb-2">Código:</label>
                <input type="text" id="codigo" name="codigo" placeholder="Ingresa tu código" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" id="canjear" class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Canjear</button>
        </form>
        <div id="mensaje" class="mt-4 text-gray-600 text-center">
            <?php
            session_start();
            if (isset($_POST['codigo'])) {
                $codigo = strtoupper($_POST['codigo']);
                if ($codigo === "UNITY" && !isset($_SESSION['codigo_canjeado'])) {
                    $_SESSION['monedas'] = isset($_SESSION['monedas']) ? $_SESSION['monedas'] + 100 : 100;
                    $_SESSION['codigo_canjeado'] = true;
                    echo "<script>
                        const confettiCanvas = document.getElementById('confetti-canvas');
                        const confettiInstance = confetti.create(confettiCanvas, {
                            resize: true,
                            useWorker: true
                        });
                        confettiInstance({
                            particleCount: 200,
                            spread: 70,
                            origin: { y: 0.6 },
                            colors: ['#facc15', '#f59e0b', '#d97706'],
                            shapes: ['circle'],
                        });
                    </script>";
                    echo "¡Código canjeado con éxito! Se han añadido 100 monedas.";
                } else if ($codigo === "UNITY" && isset($_SESSION['codigo_canjeado'])) {
                    echo "El código ya ha sido canjeado.";
                } else if ($codigo === "") {
                    echo "Por favor, ingresa un código.";
                }else {
                    echo "Código inválido. Por favor, intenta de nuevo.";
                }
                echo "<br>";
            }
            ?>
        </div>
    </div>
    <script>
        const confettiCanvas = document.getElementById('confetti-canvas');
        const confettiInstance = confetti.create(confettiCanvas, {
            resize: true,
            useWorker: true
        });
    </script>
</body>
</html>
