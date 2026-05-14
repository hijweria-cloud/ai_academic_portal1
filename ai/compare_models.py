import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.tree import DecisionTreeRegressor
from xgboost import XGBRegressor
from catboost import CatBoostRegressor
from sklearn.metrics import mean_absolute_error, mean_squared_error, r2_score
import joblib

# 1. Load Dataset

try:
    df = pd.read_csv('student-mat.csv')
    if len(df.columns) < 2:  # Agar columns sahi divide nahi huye
        df = pd.read_csv('student-mat.csv', sep=';')
except Exception as e:
    print(f"Error loading file: {e}")

print("Found columns:", df.columns.tolist())

# 2. Select Features as per requirement
features = ['G1', 'G2', 'studytime', 'failures', 'absences']
X = df[features]
y = df['G3']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# 3. Define Models for Comparison
models = {
    "Decision Tree": DecisionTreeRegressor(random_state=42),
    "Random Forest": RandomForestRegressor(n_estimators=100, random_state=42),
    "XGBoost": XGBRegressor(n_estimators=100, learning_rate=0.1, random_state=42),
    "CatBoost": CatBoostRegressor(iterations=100, learning_rate=0.1, silent=True, random_state=42)
}

results = []
best_r2 = -1
best_model_name = ""

# 4. Train and Compare
print("\nTraining models... please wait.")
for name, model in models.items():
    model.fit(X_train, y_train)
    preds = model.predict(X_test)
    
    mae = mean_absolute_error(y_test, preds)
    rmse = np.sqrt(mean_squared_error(y_test, preds))
    r2 = r2_score(y_test, preds)
    
    results.append({"Model": name, "MAE": mae, "RMSE": rmse, "R2": r2})
    
    # DYNAMIC BEST MODEL SELECTION: 
    
    if r2 > best_r2:
        best_r2 = r2
        best_model_name = name
        joblib.dump(model, 'best_student_model.pkl')

# 5. Display Comparison Table
res_df = pd.DataFrame(results)
print("\n--- Thesis Model Comparison Table ---")
print(res_df)
print(f"\nWINNER: {best_model_name} is saved as 'best_student_model.pkl' with R2: {round(best_r2, 4)}")

# 6. Generate and Save Graph for Report
plt.figure(figsize=(10, 6))
# Accuracy plot bar chart
sns.barplot(x='Model', y='R2', data=res_df, palette='viridis')
plt.title('Accuracy Comparison ($R^2$ Score)')
plt.ylabel('R2 Accuracy Score')
plt.savefig('comparison_graph.png')
print("\nGraph saved as 'comparison_graph.png'. Use this in  thesis!")