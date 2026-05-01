<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI Chatbot</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f1f3; /* beige-pink background */
      color: #2d2d2d;
    }

    /* Floating Chatbot Button */
    #chatbot-btn {
      position: fixed;
      bottom: 25px;
      right: 25px;
      background-color: #a06cd5; /* soft purple */
      color: white;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      box-shadow: 0 0 15px rgba(160, 108, 213, 0.6);
      font-size: 26px;
      cursor: pointer;
      transition: 0.3s ease;
      z-index: 999;
    }

    #chatbot-btn:hover {
      box-shadow: 0 0 25px rgba(160, 108, 213, 0.9);
      transform: scale(1.05);
    }

    /* Chat Window */
    #chatbot-box {
      position: fixed;
      bottom: 100px;
      right: 25px;
      width: 330px;
      height: 450px;
      background-color: #fefbff; /* soft beige */
      border: 2px solid #c9a0dc; /* pastel border */
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(147, 54, 253, 0.3);
      display: none;
      flex-direction: column;
      overflow: hidden;
      animation: slideUp 0.4s ease;
      z-index: 998;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .chat-header {
      background-color: #a06cd5;
      color: #fff;
      text-align: center;
      padding: 10px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .chat-body {
      flex: 1;
      padding: 10px;
      background-color: #fdf8ff;
      overflow-y: auto;
    }

    .msg {
      margin: 8px 0;
      padding: 8px 12px;
      border-radius: 12px;
      max-width: 85%;
      line-height: 1.4;
      word-wrap: break-word;
    }

    .user-msg {
      background-color: #d8c7ff;
      align-self: flex-end;
      color: #222;
      box-shadow: 0 0 5px rgba(147, 54, 253, 0.2);
    }

    .bot-msg {
      background-color: #f3e1ff;
      align-self: flex-start;
      color: #111;
      box-shadow: 0 0 5px rgba(147, 54, 253, 0.2);
    }

    .chat-input {
      display: flex;
      padding: 8px;
      border-top: 1px solid #ddd;
      background-color: #fff;
    }

    .chat-input input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 20px;
      outline: none;
      font-size: 0.9rem;
    }

    .chat-input button {
      background-color: #a06cd5;
      color: white;
      border: none;
      border-radius: 20px;
      padding: 8px 16px;
      margin-left: 8px;
      transition: 0.3s;
    }

    .chat-input button:hover {
      background-color: #9336fd;
    }
  </style>
</head>

<body>
  <!-- Floating Chatbot Icon -->
  <button id="chatbot-btn">
    💬
  </button>

  <!-- Chatbot Window -->
  <div id="chatbot-box" class="d-flex">
    <div class="chat-header">AI Assistant</div>
    <div class="chat-body" id="chat-body"></div>
    <div class="chat-input">
      <input type="text" id="user-input" placeholder="Type your message...">
      <button id="send-btn">Send</button>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      // Toggle chatbot window
      $("#chatbot-btn").click(function () {
        $("#chatbot-box").fadeToggle(300);
      });

      // Send message
      $("#send-btn").click(sendMessage);
      $("#user-input").keypress(function (e) {
        if (e.which === 13) sendMessage();
      });

      function sendMessage() {
        let userText = $("#user-input").val().trim();
        if (userText === "") return;

        $("#chat-body").append(`<div class='msg user-msg'>${userText}</div>`);
        $("#user-input").val("");
        scrollToBottom();

        $.ajax({
          url: "http://127.0.0.1:5000/chat",
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({ message: userText }),
          success: function (response) {
            $("#chat-body").append(`<div class='msg bot-msg'>${response.reply}</div>`);
            scrollToBottom();
          },
          error: function () {
            $("#chat-body").append(`<div class='msg bot-msg'>⚠️ Server not responding.</div>`);
            scrollToBottom();
          }
        });
      }

      function scrollToBottom() {
        let chatBody = $("#chat-body");
        chatBody.scrollTop(chatBody[0].scrollHeight);
      }
    });
  </script>
</body>
</html>
