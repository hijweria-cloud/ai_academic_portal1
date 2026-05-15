<?php
// 1. Session aur Database connection sab se upar
session_start();
include('includes/db_connect.php'); 
include('includes/header.php');

// 2. SECURITY FIX: Semester ko integer mein badalna (Reflected XSS se bachne ke liye)
$semester = isset($_GET['semester']) ? (int)$_GET['semester'] : 1;
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semester <?php echo htmlspecialchars($semester); ?> Subjects | GC University Faisalabad</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    html, body { height: 100%; margin: 0; }
    body { display: flex; flex-direction: column; font-family: 'Poppins', sans-serif; background-color: #FAF3E0; color: #1C1C1C; }
    .content-wrapper { flex: 1 0 auto; }
    h1 { color: #B8860B; font-weight: 700; }
    .card { background: #fff; border-radius: 15px; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); border: 1px solid rgba(180, 140, 20, 0.2); }
    .table thead { background-color: #1C1C1C; color: #D4AF37; }
    .badge { background-color: #D4AF37 !important; color: #1C1C1C !important; font-weight: 600; }
    .btn-custom { background-color: #D4AF37; color: #1C1C1C; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 500; transition: 0.3s; }
    .btn-custom:hover { background-color: #B9962F; color: #fff; }
  </style>
</head>

<body>
  <div class="content-wrapper">
    <div class="container my-5">
      <div class="text-center mb-5">
        <h1 class="fw-bold">Semester <?php echo htmlspecialchars($semester); ?> Performance</h1>
        <p class="text-muted">Academic records verified and fetched from the university database.</p>
      </div>

      <div class="card p-4">
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="text-center">
              <tr>
                <th>Subject Name</th>
                <th colspan="2">Mid-Term</th>
                <th colspan="2">Assignments</th>
                <th colspan="2">Presentations</th>
                <th>Overall</th>
              </tr>
              <tr>
                <th></th>
                <th>Total</th><th>Obt.</th>
                <th>Total</th><th>Obt.</th>
                <th>Total</th><th>Obt.</th>
                <th>%</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
              // 3. DATABASE FETCH: Hard-coded array khatam, ab asli data aayega
              $sql = "SELECT subject_name, mid_total, mid_obtained, assignment_total, assignment_obtained, presentation_total, presentation_obtained FROM marks WHERE student_id = ? AND semester = ?";
              $stmt = $conn->prepare($sql);
              
              if ($stmt) {
                  $stmt->bind_param("ii", $student_id, $semester);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          $total = $row['mid_total'] + $row['assignment_total'] + $row['presentation_total'];
                          $obt = $row['mid_obtained'] + $row['assignment_obtained'] + $row['presentation_obtained'];
                          $perc = ($total > 0) ? round(($obt / $total) * 100, 1) : 0;
                          
                          // Low performance row highlight (Sir's requirement)
                          $bg_style = ($perc < 40) ? "class='table-danger'" : "";
                          
                          echo "<tr $bg_style>
                                  <td class='text-start'><strong>" . htmlspecialchars($row['subject_name']) . "</strong></td>
                                  <td>{$row['mid_total']}</td><td>{$row['mid_obtained']}</td>
                                  <td>{$row['assignment_total']}</td><td>{$row['assignment_obtained']}</td>
                                  <td>{$row['presentation_total']}</td><td>{$row['presentation_obtained']}</td>
                                  <td><span class='badge'>{$perc}%</span></td>
                                </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='8' class='py-4 text-center'>No academic records found for this semester.</td></tr>";
                  }
                  $stmt->close();
              } else {
                  echo "<tr><td colspan='8' class='py-4 text-danger'>Database Error: Could not prepare statement.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="text-center mt-5 mb-5">
        <div class="card p-4 shadow-sm mx-auto" style="border: 2px dashed #D4AF37; max-width: 800px;">
          <h3 class="fw-bold" style="color: #B8860B;">🤖 AI GPA Predictor</h3>
          <p class="text-muted">Predict your results using the Decision Tree Regressor model.</p>
          <a href="ai_prediction.php" class="btn btn-custom px-5">Check My Forecast</a>
        </div>
      </div>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
  <?php include('includes/chatbot.php'); ?>
</body>
</html>