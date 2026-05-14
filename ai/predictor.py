import sys
import joblib
import os
import json
import numpy as np
import warnings

# Sari warnings ko hide karein takay output sirf JSON rahay
warnings.filterwarnings("ignore")

def predict_grade():
    try:
        # PHP se 5 arguments receive karna: [G1, G2, studytime, failures, absences]
        if len(sys.argv) < 6:
            print(json.dumps({"status": "error", "message": "Missing input arguments"}))
            return

        # Inputs ko float mein convert karna
        input_data = [float(arg) for arg in sys.argv[1:6]]
        
        # Model file ka path (Decision Tree model jo  train kiya)
        model_path = os.path.join(os.path.dirname(__file__), 'best_student_model.pkl')
        
        if not os.path.exists(model_path):
            print(json.dumps({"status": "error", "message": "Model file not found in ai folder"}))
            return

        # Model load karna
        model = joblib.load(model_path)
        
        # Prediction
        prediction = model.predict([input_data])[0]
        
        # Result ko 4.0 GPA scale par convert karna
        predicted_gpa = round((prediction / 20) * 4, 2)
        
        # GPA limits set karna
        predicted_gpa = max(0.0, min(4.0, predicted_gpa))
        
        # Final Clean JSON Output
        print(json.dumps({
            "status": "success",
            "predicted_score": round(float(prediction), 2),
            "predicted_gpa": predicted_gpa
        }))

    except Exception as e:
        print(json.dumps({"status": "error", "message": str(e)}))

if __name__ == "__main__":
    predict_grade()