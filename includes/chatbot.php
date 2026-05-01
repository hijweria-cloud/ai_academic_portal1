<!-- Chatbot Icon -->
<div id="chatbot-icon">💬</div>

<!-- Chatbot Window -->
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

<style>
  /* === Chatbot Styling (Dark + Gold) === */
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
    box-shadow: 0 0 10px rgba(212,175,55,0.4);
    cursor: pointer;
    z-index: 1000;
    transition: 0.3s ease;
  }
  #chatbot-icon:hover {
    transform: scale(1.1);
    background: #D4AF37;
    color: #1C1C1C;
    box-shadow: 0 0 18px rgba(212,175,55,0.6);
  }

  #chatbot-window {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 360px;
    height: 480px;
    background: #F9F6F0;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
    border: 1px solid rgba(212,175,55,0.4);
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
  #file-input { display: none; }
  #upload-btn {
    margin-right: 5px;
    background: #1C1C1C;
    color: #D4AF37;
    border-radius: 6px;
    padding: 8px 10px;
    cursor: pointer;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<script>
  const chatbotIcon = document.getElementById('chatbot-icon');
  const chatbotWindow = document.getElementById('chatbot-window');
  const apiBase = "http://localhost:5000"; // or your backend URL

  chatbotIcon.onclick = () => {
    chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
  };

  // Send message
  document.getElementById('send-btn').addEventListener('click', sendMessage);
  document.getElementById('user-input').addEventListener('keypress', e => {
    if (e.key === 'Enter') sendMessage();
  });

  function appendMessage(content, type) {
    const msg = document.createElement('div');
    msg.classList.add('chat-msg', type === 'user' ? 'user-msg' : 'bot-msg');
    msg.textContent = content;
    document.getElementById('chatbot-messages').appendChild(msg);
    document.getElementById('chatbot-messages').scrollTop = document.getElementById('chatbot-messages').scrollHeight;
  }

  function sendMessage() {
    const input = document.getElementById('user-input');
    const message = input.value.trim();
    if (!message) return;
    appendMessage(message, 'user');
    input.value = '';

    fetch(apiBase + '/chat', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ message })
    })
    .then(res => res.json())
    .then(data => appendMessage(data.reply, 'bot'))
    .catch(() => appendMessage('⚠️ Server not responding.', 'bot'));
  }

  document.getElementById('file-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('file', file);
    appendMessage(`📎 ${file.name}`, 'user');

    fetch(apiBase + '/upload', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => appendMessage(data.reply, 'bot'))
    .catch(() => appendMessage('⚠️ Upload failed.', 'bot'));
  });
</script>
