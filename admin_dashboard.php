<?php 
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | AI Academic Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
            color: #1C1C1C;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #1C1C1C;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 0.8rem 1.2rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: #D4AF37 !important;
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: #F5EBDD !important;
            margin: 0 18px;
            transition: 0.3s;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #D4AF37 !important;
            text-shadow: 0 0 6px rgba(212, 175, 55, 0.5);
        }

        .dashboard {
            flex: 1;
            margin-top: 120px;
            text-align: center;
        }

        h2 {
            color: #1C1C1C;
            font-weight: 700;
            margin-bottom: 50px;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 18px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 25px;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        .card h5 {
            color: #1C1C1C;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .card p {
            color: #4A403A;
            font-size: 0.95rem;
        }

        .btn-custom {
            background-color: #D4AF37;
            color: #1C1C1C;
            border-radius: 10px;
            border: none;
            width: 100%;
            padding: 10px 0;
            transition: 0.3s;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
        }

        .btn-custom:hover {
            background-color: #B9962F;
            color: #F5EBDD;
            transform: scale(1.05);
            box-shadow: 0 0 14px rgba(185, 150, 47, 0.4);
        }

        footer {
            background: #1C1C1C;
            text-align: center;
            padding: 15px;
            color: #D4AF37;
            font-size: 0.9rem;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.2);
        }

        #chatbot-icon {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            background: #1C1C1C;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 26px;
            color: #D4AF37;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
            cursor: pointer;
            z-index: 1000;
            transition: 0.3s ease;
        }

        #chatbot-icon:hover {
            transform: scale(1.1);
            background: #D4AF37;
            color: #1C1C1C;
            box-shadow: 0 0 18px rgba(212, 175, 55, 0.6);
        }

        #chatbot-window {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 360px;
            height: 480px;
            background: #F9F6F0;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(212, 175, 55, 0.4);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 999;
            animation: fadeUp 0.4s ease;
        }

        #chatbot-header {
            background: #1C1C1C;
            color: #D4AF37;
            padding: 12px;
            text-align: center;
            font-weight: 600;
        }

        #chatbot-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            color: #1C1C1C;
            background: #FFF9F2;
        }

        .chat-msg {
            margin-bottom: 8px;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .user-msg {
            background: #1C1C1C;
            color: #D4AF37;
            align-self: flex-end;
            margin-left: auto;
        }

        .bot-msg {
            background: #F3E2C7;
            color: #1C1C1C;
            align-self: flex-start;
            margin-right: auto;
        }

        #chatbot-input {
            display: flex;
            border-top: 1px solid #D4AF37;
            background: #F5EBDD;
            padding: 8px;
        }

        #chatbot-input input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            color: #1C1C1C;
            padding: 8px;
        }

        #chatbot-input button {
            border: none;
            background: #1C1C1C;
            color: #D4AF37;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        #chatbot-input button:hover {
            background: #D4AF37;
            color: #1C1C1C;
        }

        #file-input {
            display: none;
        }

        #upload-btn {
            margin-right: 5px;
            background: #1C1C1C;
            color: #D4AF37;
            border-radius: 6px;
            padding: 8px 10px;
            cursor: pointer;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">AI Academic Portal</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                    <li><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container dashboard">
        <h2>Welcome, Admin</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div>
                        <h5>Manage Students</h5>
                        <p>View, edit, or remove students</p>
                    </div>
                    <a href="manage_students.php" class="btn btn-custom mt-auto">Open</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div>
                        <h5>Manage Programs</h5>
                        <p>Add or delete programs</p>
                    </div>
                    <a href="manage_programs.php" class="btn btn-custom mt-auto">Open</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div>
                        <h5>Manage Semesters</h5>
                        <p>Set subjects and marks</p>
                    </div>
                    <a href="manage_semesters.php" class="btn btn-custom mt-auto">Open</a>
                </div>
            </div>
        </div>
    </div>

    <div id="chatbot-icon">💬</div>
    <div id="chatbot-window">
        <div id="chatbot-header">AI Assistant</div>
        <div id="chatbot-messages"></div>
        <div id="chatbot-input">
            <label for="file-input" id="upload-btn">📎</label>
            <input type="file" id="file-input" accept="image/*">
            <input type="text" id="user-input" placeholder="Type your message...">
            <button id="send-btn">Send</button>
        </div>
    </div>

    <footer>&copy; 2025 Aspire College | AI-Based Academic Portal</footer>

    <script>
        const chatbotIcon = document.getElementById('chatbot-icon');
        const chatbotWindow = document.getElementById('chatbot-window');
        const apiBase = "http://localhost:5000";

        chatbotIcon.onclick = () => {
            chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
        };

        $('#send-btn').click(function () {
            const message = $('#user-input').val().trim();
            if (!message) return;

            $('#chatbot-messages').append(`<div class="chat-msg user-msg">${message}</div>`);
            $('#user-input').val('');
            $('#chatbot-messages').scrollTop($('#chatbot-messages')[0].scrollHeight);

            fetch(apiBase + '/chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(data => {
                $('#chatbot-messages').append(`<div class="chat-msg bot-msg">${data.reply}</div>`);
                $('#chatbot-messages').scrollTop($('#chatbot-messages')[0].scrollHeight);
            })
            .catch(() => {
                $('#chatbot-messages').append(`<div class="chat-msg bot-msg">⚠️ Server not responding.</div>`);
            });
        });

        $('#file-input').on('change', function () {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);

            $('#chatbot-messages').append(`<div class="chat-msg user-msg">📎 ${file.name}</div>`);

            fetch(apiBase + '/upload', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                $('#chatbot-messages').append(`<div class="chat-msg bot-msg">${data.reply}</div>`);
                $('#chatbot-messages').scrollTop($('#chatbot-messages')[0].scrollHeight);
            })
            .catch(() => {
                $('#chatbot-messages').append(`<div class="chat-msg bot-msg">⚠️ Upload failed.</div>`);
            });
        });
    </script>
</body>
</html>
