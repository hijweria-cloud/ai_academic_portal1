<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/header.php');

// Get semester number from URL (example: subjects.php?semester=3)
$semester = isset($_GET['semester']) ? $_GET['semester'] : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semester <?php echo $semester; ?> Subjects | AI Academic Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* === Base Theme === */
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      background-color: #FAF3E0; /* light beige */
      color: #1C1C1C;
      overflow-x: hidden;
    }

    h1 {
      color: #B8860B; /* gold-brown */
      font-weight: 700;
    }

    .text-muted {
      color: #333 !important;
      font-weight: 500;
    }

    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(180, 140, 20, 0.2);
    }

    .table {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .table thead {
      background-color: #1C1C1C;
      color: #D4AF37; /* gold */
    }

    .table tbody tr:hover {
      background-color: #FFF8E7;
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

    footer {
      background-color: #1C1C1C !important;
      color: #F5EBDD !important;
    }
  </style>
</head>

<body>
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
            // Sample subjects (you can later fetch from DB)
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
              </tr>
              ";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="semesters.php" class="btn btn-custom">⬅ Back to Semesters</a>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
  <?php include('includes/chatbot.php'); ?>

</body>
</html>
