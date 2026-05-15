from flask import Flask, request, jsonify
from flask_cors import CORS
from google import genai
import json
import re
import base64
import os
from dotenv import load_dotenv

# .env file se keys load karne ke liye
load_dotenv()

app = Flask(__name__)
CORS(app)  # allow frontend access

# --- FIX 1: Gemini API Key (Code se hata kar .env se uthayi hai) ---
API_KEY = os.getenv("GEMINI_API_KEY")

if not API_KEY:
    # Agar key na mile toh system error dikhaye ga
    print("CRITICAL ERROR: GEMINI_API_KEY not found in .env file.")

# Gemini client init
client = genai.Client(api_key=API_KEY)

# --- FIX 2: General Upload Path for Portability ---
# __file__ use kiya hai taake examiner ke computer par rasta khud dhoond le
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
UPLOAD_FOLDER = os.path.join(BASE_DIR, "uploads")
os.makedirs(UPLOAD_FOLDER, exist_ok=True)


# loading intents
intents_path = os.path.join(BASE_DIR, "intents.json")
with open(intents_path, "r", encoding="utf-8") as f:
    intents = json.load(f)


# match user message with predefined intents
def get_intent_response(user_message):
    for intent in intents["intents"]:
        for pattern in intent["patterns"]:
            if re.search(r'\b' + re.escape(pattern.lower()) + r'\b', user_message.lower()):
                return intent["responses"][0]
    return None


# if no intent matches, call gemini
def get_gemini_response(user_message):
    try:
        # --- Prompt Engineering (Describes the module as an academic counselor) ---
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

        response = client.models.generate_content(
            model="gemini-1.5-flash", # Updated to a stable model version
            contents=[prompt]
        )

        if hasattr(response, "text"):
            return response.text.strip()
        return "⚠️ No valid reply from Gemini."
    except Exception as e:
        return f"⚠️ Error contacting Gemini: {str(e)}"


# image upload + analysis
@app.route("/upload", methods=["POST"])
def upload_file():
    file = request.files.get("file")
    if not file:
        return jsonify({"reply": "⚠️ No file received."})

    filepath = os.path.join(UPLOAD_FOLDER, file.filename)
    file.save(filepath)

    # check file type
    if file.filename.lower().endswith((".png", ".jpg", ".jpeg")):
        try:
            with open(filepath, "rb") as img_file:
                image_data = base64.b64encode(img_file.read()).decode("utf-8")

            response = client.models.generate_content(
                model="gemini-1.5-flash", # Use multimodal capable model
                contents=[
                    "Explain the content of this image in context of academics.",
                    {"inline_data": {"mime_type": "image/jpeg", "data": image_data}}
                ]
            )

            if hasattr(response, "text"):
                return jsonify({"reply": response.text.strip()})
            return jsonify({"reply": "⚠️ Image analyzed but no text output."})
        except Exception as e:
            return jsonify({"reply": f"⚠️ Error analyzing image: {str(e)}"})
    else:
        return jsonify({"reply": "✅ File uploaded successfully but only images can be analyzed."})


# main chat route
@app.route("/chat", methods=["POST"])
def chat():
    data = request.get_json()
    user_message = data.get("message", "").strip()

    if not user_message:
        return jsonify({"reply": "⚠️ Please enter a message."})

    # first check intents
    intent_response = get_intent_response(user_message)
    if intent_response:
        return jsonify({"reply": intent_response})

    # if no match, use gemini
    ai_response = get_gemini_response(user_message)
    return jsonify({"reply": ai_response})


if __name__ == "__main__":
    # --- FIX 3: Secure Deployment ---
    # Debug mode production mein false hona chahiye, aur host specify karna behtar hai
    app.run(host="127.0.0.1", port=5000, debug=False)