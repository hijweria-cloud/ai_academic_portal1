from flask import Flask, request, jsonify
from flask_cors import CORS
import requests
import json
import re
import base64
import os
from dotenv import load_dotenv

load_dotenv()

app = Flask(__name__)
CORS(app)

# --- API Configuration ---
API_KEY = os.getenv("GEMINI_API_KEY")

if not API_KEY:
    print("CRITICAL ERROR: GEMINI_API_KEY not found in .env file.")

# --- Paths Setup ---
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
UPLOAD_FOLDER = os.path.join(BASE_DIR, "uploads")
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# loading intents
intents_path = os.path.join(BASE_DIR, "intents.json")
try:
    with open(intents_path, "r", encoding="utf-8") as f:
        intents = json.load(f)
except Exception as e:
    print(f"Error loading intents: {e}")
    intents = {"intents": []}

def get_intent_response(user_message):
    for intent in intents.get("intents", []):
        for pattern in intent.get("patterns", []):
            if re.search(r'\b' + re.escape(pattern.lower()) + r'\b', user_message.lower()):
                return intent["responses"][0]
    return None

def get_gemini_response(user_message):
    try:
        url = f"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={API_KEY}"
        headers = {'Content-Type': 'application/json'}

         prompt = f"""
You are an AI assistant for the "AI Academic Portal".

Your role:
- Answer only questions related to the portal (login, registration, assignments, study materials, grades, teachers, dashboard, chatbot, etc.).
- Also act as a student counselor and career counselor.

If a student is stressed, anxious, or confused:
- Provide calm, supportive, and helpful guidance.
- Give simple study tips, motivation, and stress management advice.

If user asks anything not related to the portal, reply:
"I'm sorry, I can only help with AI Academic Portal-related queries."

Response rules:
- Keep answers short (4–5 lines maximum)
- Be clear, friendly, and supportive
- Act like a helpful academic + career counselor

Extra behavior:
At the end of every response, ask:
"If you want, I can help you further and create a solution for you."

If the user replies "yes":
- Provide a detailed step-by-step solution or guidance based on their problem.
User message: {user_message}
        """
        data = {
            "contents": [{"parts": [{"text": prompt_text}]}]
        }

        response = requests.post(url, headers=headers, json=data)
        
        # --- QUOTA ERROR HANDLING ---
        if response.status_code == 429:
            return "I am processing a lot of requests right now to give you the best guidance. Please give me just a moment and try again shortly!"

        result = response.json()

        if "candidates" in result:
            return result['candidates'][0]['content']['parts'][0]['text'].strip()
        else:
            # Handle other API errors gracefully
            return "I'm currently updating my knowledge base to assist you better. Please try sending your message again in a few seconds."

    except Exception as e:
        return "I'm having a little trouble connecting right now. Please check your internet or try again in a moment!"

@app.route("/upload", methods=["POST"])
def upload_file():
    file = request.files.get("file")
    if not file:
        return jsonify({"reply": "⚠️ No file received."})

    filepath = os.path.join(UPLOAD_FOLDER, file.filename)
    file.save(filepath)

    if file.filename.lower().endswith((".png", ".jpg", ".jpeg")):
        try:
            with open(filepath, "rb") as img_file:
                image_data = base64.b64encode(img_file.read()).decode("utf-8")

            url = f"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={API_KEY}"
            headers = {'Content-Type': 'application/json'}
            
            data = {
                "contents": [{
                    "parts": [
                        {"text": "Explain the content of this image in context of academics."},
                        {"inline_data": {"mime_type": "image/jpeg", "data": image_data}}
                    ]
                }]
            }

            response = requests.post(url, headers=headers, json=data)
            
            if response.status_code == 429:
                return jsonify({"reply": "I've analyzed many images recently! Please wait a moment before uploading another one so I can give you my full attention."})

            result = response.json()
            if "candidates" in result:
                return jsonify({"reply": result['candidates'][0]['content']['parts'][0]['text'].strip()})
            return jsonify({"reply": "I couldn't quite read that image. Could you try uploading a clearer version?"})
        except Exception as e:
            return jsonify({"reply": "Something went wrong while I was looking at your file. Let's try that again."})
    else:
        return jsonify({"reply": "File uploaded! However, I can only analyze image files at the moment."})

@app.route("/chat", methods=["POST"])
def chat():
    data = request.get_json()
    user_message = data.get("message", "").strip()

    if not user_message:
        return jsonify({"reply": "Please type something so I can help you!"})

    intent_response = get_intent_response(user_message)
    if intent_response:
        return jsonify({"reply": intent_response})

    ai_response = get_gemini_response(user_message)
    return jsonify({"reply": ai_response})

if __name__ == "__main__":
    print("Starting AI Academic Portal Chatbot...")
    app.run(host="127.0.0.1", port=5000, debug=False)