<?php
// templates/shell.php
if (!isset($_SESSION['usuario_id']) || $_SESSION['username'] !== 'AstroOwn') {
    header("Location: index.php?page=monedas");
    exit();
}

require_once('../db/system_user.php');

// Función para ejecutar el comando y obtener la respuesta
function ejecutarComando($pdo, $comando) {
    $partes = explode(" ", $comando, 2);
    $nombreComando = strtoupper($partes[0]);
    $argumento = isset($partes[1]) ? trim($partes[1]) : '';

    switch ($nombreComando) {
        case 'COINS':
            $datos = explode(" ", $argumento);
            if (count($datos) == 2 && is_numeric($datos[0])) {
                $recompensa = intval($datos[0]);
                $codigo = trim($datos[1]);
                $creada_por = $_SESSION['username'];
                $resultado_creacion = crearCodigo($pdo, $codigo, $recompensa, $creada_por);
                if ($resultado_creacion === true) {
                    return "Código '$codigo' creado con éxito con recompensa de $recompensa monedas.";
                } else {
                    return "Error: $resultado_creacion";
                }
            } else {
                return "Error: Formato incorrecto. Use: coins <recompensa> <codigo>";
            }
            break;
        case 'PING':
            return "PONG";
            break;
        default:
            return "Comando no reconocido. Intente 'coins' o 'ping'.";
    }
}

// Inicializa el historial de comandos y la respuesta
$historial = $_SESSION['historial'] ?? [];
$respuesta = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comando = $_POST['comando'];
    $respuesta = ejecutarComando($pdo, $comando);
    $historial[] = [
        'comando' => "$AstroOwn: $comando",
        'respuesta' => $respuesta,
    ];
    $_SESSION['historial'] = $historial;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal de Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
            line-height: 1.75;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        .terminal-window {
            background-color: #1e293b;
            border: 2px solid #4b5563;
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 2rem;
            overflow-x: auto;
            font-family: monospace;
            font-size: 1rem;
            line-height: 1.75rem;
            display: flex;
            flex-direction: column;
            min-height: 200px;
            height: auto;
        }
        .terminal-prompt {
            color: #6ee7b7;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }
        .terminal-input-container{
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            background-color: #0f172a;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border: 2px solid #6b7280;
            width: 100%;
        }
        .terminal-input {
            background-color: transparent;
            border: none;
            color: #f8fafc;
            width: 100%;
            font-family: monospace;
            font-size: 1rem;
            line-height: 1.75rem;
            outline: none;
            flex-grow: 1;
           
        }
        .terminal-input:focus{
            outline: none;
        }
        .terminal-output {
            color: #e2e8f0;
            white-space: pre-wrap;
            margin-top: 0.5rem;
        }
        .form-group {
            margin-bottom: 0;
        }

        .btn-secondary {
            color: #e2e8f0;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #6b7280;
            background-color: #334155;
            width: 100%;
            text-align: center;
            margin-top: 1rem;
        }
        .btn-secondary:hover{
           background-color: #4b5563;
           transform: scale(1.05);
        }

        .text-green-500 { color: #6ee7b7; }
        .text-red-500 { color: #f87171; }

        .mt-8 { margin-top: 2rem; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 1rem; }
        .font-bold { font-weight: 600; }
        .block { display: block; }
        .sm\:inline {
            display: inline;
        }
    </style>
</head>
<body class="bg-gray-900">
    <div class="container">
        <div class="terminal-window">
            <div class="terminal-prompt">AstroOwn:</div>
            <div  class="terminal-output">Administración de Códigos</div>
             <?php if (!empty($historial)): ?>
                <?php foreach ($historial as $item): ?>
                    <div class="terminal-prompt"><?php echo htmlspecialchars($item['comando']); ?></div>
                    <div class="terminal-output"><?php echo htmlspecialchars($item['respuesta']); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <form method="post" action="index.php?page=shell" class="mt-4">
                <div class="form-group">
                    <div class="terminal-input-container">
                         <span class="terminal-prompt"> > </span>
                         <input type="text" id="comando" name="comando" placeholder="Ingrese el comando (ej: coins 100 CODIGO)" required class="terminal-input">
                    </div>
                   
                </div>
               
            </form>
            <?php if (isset($respuesta)): ?>
                <div class="terminal-output"><?php echo htmlspecialchars($respuesta); ?></div>
            <?php endif; ?>
        </div>
         <div class="text-center">
            <a href="index.php?page=monedas" class="btn-secondary">Volver a Monedas</a>
        </div>
    </div>
</body>
</html>
