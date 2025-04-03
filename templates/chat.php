<?php
// templates/chat.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Telegram</title>
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
            height: 100vh; /* Altura completa de la ventana */
        }
        .sidebar {
            width: 300px;
            background-color: #1e293b; /* Fondo blanco */
            border-right: 1px solid #4b5563; /* Borde inferior gris */
            display: flex;
            flex-direction: column;
        }
        .sidebar-header{
            padding: 1rem;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #4b5563;
        }
        .search-container {
            padding: 0.75rem;
            border-bottom: 1px solid #4b5563;
            display: flex;
            align-items: center;
        }
        .search-input {
            border-radius: 0.5rem; /* Bordes redondeados */
            padding: 0.75rem 1rem; /* Relleno */
            width: 100%; /* Ancho completo */
            border: 1px solid #6b7280; /* Borde gris */
            outline: none; /* Sin contorno por defecto */
            transition: border-color 0.2s ease-in-out; /* Transición suave del borde */
            background-color: #334155;
            color: #f8fafc;
        }
        .search-input:focus {
            border-color: #3b82f6; /* Borde azul al enfocar */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); /* Sombra azul al enfocar */
        }
        .search-icon {
           /* Icono de lupa SVG */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E");
            background-size: cover;
            background-position: center;
            width: 24px;
            height: 24px;
            cursor: pointer;
            opacity: 0.7;
            margin-left: 0.5rem;
        }
        .user-list {
            flex-grow: 1; /* El contenido principal ocupa el espacio restante */
            overflow-y: auto; /* Scroll vertical si es necesario */
            padding: 0.5rem;
        }
        .user-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #4b5563; /* Separador entre usuarios */
            cursor: pointer; /* Cursor de puntero al pasar el mouse */
            transition: background-color 0.2s ease-in-out; /* Transición suave del fondo */
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
        }
        .user-item:hover {
            background-color: #334155;
        }
        .user-avatar {
            width: 2.5rem; /* Tamaño del avatar */
            height: 2.5rem;
            border-radius: 50%; /* Hace que el avatar sea un círculo */
            margin-right: 1rem; /* Espacio entre el avatar y el nombre */
            background-color: #9ca3af; /* Color de fondo gris para el avatar */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            font-weight: 600;
             background-image: url('resource/telegram$1.png');
            background-size: cover;
            background-position: center;
        }
        .chat-window {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #4b5563;
        }
        .chat-header {
            background-color: #1e293b;
            padding: 0.75rem;
            border-bottom: 1px solid #4b5563;
            text-align: left;
            font-weight: 600;
            font-size: 1.25rem;
            border-radius: 0.5rem 0.5rem 0 0;
            color: #fff;
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
            background-color: #e0f2fe;
            margin-left: auto;
            max-width: 70%;
            text-align: right;
             box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            color: #000;

        }

         .message-item.other {
            background-color: #f0f4f8;
            margin-left: 0;
            margin-right: auto;
            text-align: left;
             box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
             color: #000;
        }

        .message-input-container {
            padding: 0.75rem;
            background-color: #1e293b;
            border-top: 1px solid #4b5563;
            display: flex;
            align-items: center;
            border-radius: 0 0 0.5rem 0.5rem;
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .message-input {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
            border: 1px solid #6b7280;
            outline: none;
            transition: border-color 0.2s ease-in-out;
            margin-right: 1rem;
            font-size: 1rem;
            color: #f8fafc;
            background-color: #334155;
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
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            
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
<body class="bg-gray-900">
    <div class="chat-container">
        <div class="sidebar">
            <div class="sidebar-header">
               Astro Messenger
            </div>
            <div class="search-container">
                <input type="text" id="user-search" placeholder="Buscar usuario..." class="search-input">
                 <img src="resource/telegram$1.png" alt="Telegram" class="search-icon">
            </div>
            <div id="user-list" class="user-list">
                </div>
        </div>
        <div id="chat-window" class="chat-window hidden">
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

        //const users = [
        //    { id: 1, name: 'Usuario 1', avatar: 'U1' },
        //    { id: 2, name: 'Usuario 2', avatar: 'U2' },
        //    { id: 3, name: 'Usuario 3', avatar: 'U3' },
        //    { id: 4, name: 'Usuario 4', avatar: 'U4' },
        //    { id: 5, name: 'Usuario 5', avatar: 'U5' },
        //];
        let users = [];
        let myId = <?php echo $_SESSION['usuario_id']?>;

        fetch('users.php')
        .then(response => response.json())
        .then(data => {
            users = data;
             displayUsers(users);
        })

        .catch(error => {
            console.error('Error al obtener la lista de usuarios:', error);
            userListContainer.innerHTML = 'Error al cargar la lista de usuarios.';
        });

        function displayUsers(users) {
            userListContainer.innerHTML = '';
            users.forEach(user => {
                const userItem = document.createElement('div');
                userItem.classList.add('user-item');
                userItem.dataset.userId = user.id;
                userItem.innerHTML = `
                    <div class="user-avatar">${user.name.substring(0,2).toUpperCase()}</div>
                    <span>${user.name}</span>
                `;
                userListContainer.appendChild(userItem);
            });
        }

        userSearchInput.addEventListener('input', () => {
            const searchTerm = userSearchInput.value.toLowerCase();
            const filteredUsers = users.filter(user => user.name.toLowerCase().includes(searchTerm));
            displayUsers(filteredUsers);
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
                 fetch(`messages.php?receiver_id=${selectedUserId}`)
                .then(response => response.json())
                .then(messages => {
                    messages.forEach(message => {
                        const messageItem = document.createElement('div');
                         messageItem.classList.add('message-item');
                        if(message.sender_id == myId){
                             messageItem.textContent = message.message;
                        }
                        else{
                            messageItem.classList.add('other');
                             messageItem.textContent = message.message;
                        }

                       
                        messageList.appendChild(messageItem);
                    });
                })
                .catch(error => {
                    console.error('Error al obtener mensajes:', error);
                    messageList.innerHTML = 'Error al cargar los mensajes.';
                });

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
               fetch('send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `receiver_id=${selectedUserId}&message=${encodeURIComponent(messageText)}`,
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success'){
                         const replyItem = document.createElement('div');
                        replyItem.classList.add('message-item', 'other');
                        replyItem.textContent = data.message;
                        messageList.appendChild(replyItem);
                    }
                    else{
                         alert('error al enviar mensaje')
                    }

                   
                })
                .catch(error => {
                    console.error('Error al enviar el mensaje:', error);
                    alert('error al enviar el mensaje')
                });
            }
        });
    </script>
</body>
</html>
