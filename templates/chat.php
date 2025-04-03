<?php
// templates/chat.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Mensajería</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos personalizados para la interfaz de chat */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Fondo gris claro */
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh; /* Altura completa de la ventana */
        }
        .search-container {
            padding: 1rem;
            background-color: #ffffff; /* Fondo blanco */
            border-bottom: 1px solid #e5e7eb; /* Borde inferior gris */
        }
        .search-input {
            border-radius: 0.5rem; /* Bordes redondeados */
            padding: 0.75rem 1rem; /* Relleno */
            width: 100%; /* Ancho completo */
            border: 1px solid #d1d5db; /* Borde gris */
            outline: none; /* Sin contorno por defecto */
            transition: border-color 0.2s ease-in-out; /* Transición suave del borde */
        }
        .search-input:focus {
            border-color: #3b82f6; /* Borde azul al enfocar */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); /* Sombra azul al enfocar */
        }
        .user-list {
            flex-grow: 1; /* El contenido principal ocupa el espacio restante */
            overflow-y: auto; /* Scroll vertical si es necesario */
            padding: 1rem;
        }
        .user-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb; /* Separador entre usuarios */
            cursor: pointer; /* Cursor de puntero al pasar el mouse */
            transition: background-color 0.2s ease-in-out; /* Transición suave del fondo */
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
        }
        .user-item:hover {
            background-color: #f0f0f0; /* Fondo gris claro al pasar el mouse */
        }
        .user-avatar {
            width: 3rem; /* Tamaño del avatar */
            height: 3rem;
            border-radius: 50%; /* Hace que el avatar sea un círculo */
            margin-right: 1rem; /* Espacio entre el avatar y el nombre */
            background-color: #9ca3af; /* Color de fondo gris para el avatar */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .chat-header {
            background-color: #ffffff;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            font-weight: 600;
            font-size: 1.25rem;
             border-radius: 0.5rem 0.5rem 0 0;
        }
        .message-list {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;

        }
        .message-item {
             margin-bottom: 0.5rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: #eff6ff;
            margin-left: auto;
            max-width: 70%;
            text-align: right;

        }

         .message-item.other {
            background-color: #f3f4f6;
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        .message-input-container {
            padding: 1rem;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
             border-radius: 0 0 0.5rem 0.5rem;
        }
        .message-input {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
            border: 1px solid #d1d5db;
            outline: none;
            transition: border-color 0.2s ease-in-out;
            margin-right: 1rem;
        }
        .message-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .send-button {
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .send-button:hover {
            background-color: #2563eb;
        }
        .hidden {
            display: none;
        }
        .flex{
            display: flex;
        }
        .items-center{
            align-items: center;
        }
        .justify-between{
            justify-content: space-between;
        }
        .mb-4{
            margin-bottom: 1rem;
        }
        .p-4{
            padding: 1rem;
        }
        .rounded-md{
            border-radius: 0.5rem;
        }
        .text-red-500{
            color: #dc2626;
        }
        .text-green-500{
            color: #16a34a;
        }
        .h-full{
            height: 100%;
        }
        .w-full{
            width: 100%;
        }

    </style>
</head>
<body class="bg-gray-100">
    <div class="chat-container">
        <div class="search-container">
            <input type="text" id="user-search" placeholder="Buscar usuario..." class="search-input">
        </div>
        <div id="user-list" class="user-list">
            </div>
        <div id="chat-window" class="hidden flex flex-col">
            <div class="chat-header">
                <span id="chat- собеседник"></span>
            </div>
            <div id="message-list" class="message-list">
                </div>
            <div class="message-input-container">
                <input type="text" id="message-input" placeholder="Escribe tu mensaje..." class="message-input">
                <button id="send-button" class="send-button">Enviar</button>
            </div>
        </div>
    </div>

    <script>
        const userSearchInput = document.getElementById('user-search');
        const userListContainer = document.getElementById('user-list');
        const chatWindow = document.getElementById('chat-window');
        const chat собеседникTitle = document.getElementById('chat- собеседник');
        const messageList = document.getElementById('message-list');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');

        const users = [
            { id: 1, name: 'Usuario 1', avatar: 'U1' },
            { id: 2, name: 'Usuario 2', avatar: 'U2' },
            { id: 3, name: 'Usuario 3', avatar: 'U3' },
            { id: 4, name: 'Usuario 4', avatar: 'U4' },
            { id: 5, name: 'Usuario 5', avatar: 'U5' },
        ];

        let selectedUserId = null;

        userSearchInput.addEventListener('input', () => {
            const searchTerm = userSearchInput.value.toLowerCase();
            const filteredUsers = users.filter(user => user.name.toLowerCase().includes(searchTerm));
            userListContainer.innerHTML = '';
            filteredUsers.forEach(user => {
                const userItem = document.createElement('div');
                userItem.classList.add('user-item');
                userItem.dataset.userId = user.id;
                userItem.innerHTML = `
                    <div class="user-avatar">${user.avatar}</div>
                    <span>${user.name}</span>
                `;
                userListContainer.appendChild(userItem);
            });
        });

        userListContainer.addEventListener('click', (event) => {
            const clickedUserItem = event.target.closest('.user-item');
            if (clickedUserItem) {
                selectedUserId = clickedUserItem.dataset.userId;
                const selectedUser = users.find(user => user.id === parseInt(selectedUserId));
                chat собеседникTitle.textContent = `Chat con ${selectedUser.name}`;
                chatWindow.classList.remove('hidden');
                messageList.innerHTML = '';
                messageInput.value = '';
            }
        });

        sendButton.addEventListener('click', () => {
            const messageText = messageInput.value.trim();
            if (messageText !== '' && selectedUserId) {
                const messageItem = document.createElement('div');
                messageItem.classList.add('message-item');
                messageItem.textContent = messageText;
                messageList.appendChild(messageItem);
                messageInput.value = '';
                // Aquí deberías enviar el mensaje al servidor (usando fetch o WebSockets)
                // y recibir la respuesta para mostrarla en el chat
                setTimeout(() => {
                    const replyItem = document.createElement('div');
                    replyItem.classList.add('message-item', 'other');
                    replyItem.textContent = 'Mensaje recibido';
                    messageList.appendChild(replyItem);
                }, 500);
            }else if(selectedUserId == null){
                 alert("seleccione un usuario")
            }
        });
    </script>
</body>
</html>
