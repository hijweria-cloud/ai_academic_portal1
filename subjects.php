<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/header.php');

// Get semester number from URL
$semester = isset($_GET['semester']) ? $_GET['semester'] : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semester <?php echo $semester; ?> Subjects | AI Academic Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* === Sticky Footer Logic === */
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      font-family: 'Poppins', sans-serif;
      background-color: #FAF3E0;
      color: #1C1C1C;
    }

    /* Is class se content area baki bachi hui jagah le lega aur footer ko niche push kar dega */
    .content-wrapper {
      flex: 1 0 auto;
    }

    h1 { color: #B8860B; font-weight: 700; }
    .text-muted { color: #333 !important; font-weight: 500; }

    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(180, 140, 20, 0.2);
    }

    .table thead {
      background-color: #1C1C1C;
      color: #D4AF37;
    }

    .badge {
      background-color: #D4AF37 !important;
      color: #1C1C1C !important;
      font-weight: 600;
    }

    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-custom:hover {
      background-color: #B9962F;
      color: #fff;
    }

    /* Footer fix */
    footer {
      flex-shrink: 0;
      background-color: #1C1C1C !important;
      color: #F5EBDD !important;
      padding: 20px 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <!-- Content Wrapper Start -->
  <div class="content-wrapper">
    <div class="container my-5">
      <div class="text-center mb-5">
        <h1 class="fw-bold">Semester <?php echo $semester; ?> Subjects</h1>
        <p class="text-muted">View your subject marks, assignments, and presentation results below.</p>
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
                <th>Total %</th>
              </tr>
              <tr>
                <th></th>
                <th>Total</th>
                <th>Obtained</th>
                <th>Total</th>
                <th>Obtained</th>
                <th>Total</th>
                <th>Obtained</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php
              $subjects = [
                ["Artificial Intelligence", 30, 25, 10, 8, 10, 9],
                ["Database Systems", 30, 27, 10, 9, 10, 8],
                ["Data Structures", 30, 24, 10, 7, 10, 9],
                ["Operating Systems", 30, 26, 10, 8, 10, 9],
              ];

              foreach ($subjects as $subject) {
                $total = $subject[1] + $subject[3] + $subject[5];
                $obtained = $subject[2] + $subject[4] + $subject[6];
                $percentage = round(($obtained / $total) * 100, 2);

                echo "
                <tr>
                  <td><strong>{$subject[0]}</strong></td>
                  <td>{$subject[1]}</td>
                  <td>{$subject[2]}</td>
                  <td>{$subject[3]}</td>
                  <td>{$subject[4]}</td>
                  <td>{$subject[5]}</td>
                  <td>{$subject[6]}</td>
                  <td><span class='badge'>{$percentage}%</span></td>
                </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- AI Prediction Link  -->
      <div class="text-center mt-5 mb-5">
        <div class="card p-4 shadow-sm mx-auto" style="border: 2px dashed #D4AF37; max-width: 800px;">
          <h3 class="fw-bold" style="color: #B8860B;">🤖 AI GPA Predictor</h3>
          <p class="text-muted">Analyze your current marks and predict your final semester result using AI.</p>
          <a href="ai_prediction.php" class="btn btn-custom px-5">Check My Forecast</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Content Wrapper End -->

  <?php include('includes/footer.php'); ?>
  <?php include('includes/chatbot.php'); ?>
</body>
</html>