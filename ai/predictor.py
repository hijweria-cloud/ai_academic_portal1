import sys
import joblib
import os
import json
import numpy as np
import warnings

# Suppress all warnings to ensure output remains pure JSON
warnings.filterwarnings("ignore")

def predict_grade():
    try:
        # Receive 5 arguments from PHP: [G1, G2, studytime, failures, absences]
        if len(sys.argv) < 6:
            print(json.dumps({"status": "error", "message": "Missing input arguments"}))
            return

        # Convert inputs to float
        # Mapping: g1=0, g2=1, study=2, failures=3, absences=4
        input_data = [float(arg) for arg in sys.argv[1:6]]
        g1 = input_data[0]
        g2 = input_data[1]
        
        # Define model path
        model_path = os.path.join(os.path.dirname(__file__), 'best_student_model.pkl')
        
        if not os.path.exists(model_path):
            print(json.dumps({"status": "error", "message": "Model file not found in ai folder"}))
            return

        # Load the Decision Tree model
        model = joblib.load(model_path)
        
        # Generate Prediction
        prediction = model.predict([input_data])[0]
        
        # Convert result to 4.0 GPA scale (Input distribution is 0-20) [cite: 52]
        predicted_gpa = round((prediction / 20) * 4, 2)
        
        # Clamp GPA between 0.0 and 4.0
        predicted_gpa = max(0.0, min(4.0, predicted_gpa))
        
        # --- NEW FEATURE: Weak Performance Identification (Review Fix §1.1) --- 
        # Flagging weak performance if marks are below 40% (8 out of 20)
        weak_areas = []
        if g1 < 8:
            weak_areas.append("Mid-term Performance (G1)")
        if g2 < 8:
            weak_areas.append("Internal/Presentation Marks (G2)")
        if input_data[4] > 10: # If absences are high
            weak_areas.append("Attendance/Consistency")

        # Prepare Final Clean JSON Output
        response = {
            "status": "success",
            "predicted_score": round(float(prediction), 2),
            "predicted_gpa": predicted_gpa,
            "weak_subjects": weak_areas if weak_areas else ["None identified"]
        }
        
        print(json.dumps(response))

    except Exception as e:
        print(json.dumps({"status": "error", "message": str(e)}))

if __name__ == "__main__":
    predict_grade()