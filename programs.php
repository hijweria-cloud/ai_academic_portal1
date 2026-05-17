<?php
session_start();
include('includes/header.php');

// User login check
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$user_program = strtolower(trim($_SESSION['program'] ?? ''));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choose Your Program | GC University Faisalabad</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #FAF3E0; font-family: 'Poppins', sans-serif; margin: 0; }

    /* === HEADER SIZE FIX === */
    .navbar {
      min-height: 50px !important;
      height: 50px !important;
      padding: 0 1rem !important;
      background-color: #1C1C1C !important;
    }
    .navbar-brand {
      font-size: 1rem !important;
      line-height: 50px !important;
      color: #D4AF37 !important;
    }
    .nav-link {
      line-height: 50px !important;
      font-size: 0.9rem !important;
      padding: 0 10px !important;
    }

    /* === LAYOUT STYLING === */
    .main-container { padding: 50px 0; }
    h1 { color: #B8860B; font-weight: 700; margin-bottom: 10px; }
    
    .card {
      background: #fff;
      border-radius: 15px;
      overflow: hidden; 
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      transition: 0.3s;
      border: none;
      height: 100%;
    }
    .card:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(0,0,0,0.2); }

    .program-banner {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 4px solid #D4AF37;
    }

    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      font-weight: 600;
      border: none;
      padding: 12px;
      border-radius: 10px;
      transition: 0.3s;
    }
    .btn-custom:hover { background-color: #B9962F; color: #fff; }
    
    footer {
      background-color: #1C1C1C;
      color: #D4AF37;
      padding: 15px 0;
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <div class="container main-container">
    <div class="text-center mb-5">
        <h1 class="display-6">Choose Your Program</h1>
        <p class="text-muted">Select your degree program to access subjects and AI assistance.</p>
    </div>

    <div class="row justify-content-center g-4">
      <?php
      $programs = [
        'bscs' => ['name' => 'BS Computer Science', 'img' => 'bscs.jpg'],
        'bsmaths' => ['name' => 'BS Mathematics', 'img' => 'bsmath.jpg']
      ];

      foreach ($programs as $key => $data) {
          $allowed = ($user_program === $key);
          ?>
          <div class="col-lg-5 col-md-6">
              <div class="card">
                <img src="img/<?php echo $data['img']; ?>" alt="<?php echo $data['name']; ?>" class="program-banner">
                
                <div class="card-body p-4 text-center">
                    <h3 class="fw-bold mb-2" style="color:#B8860B;"><?php echo $data['name']; ?></h3>
                    <p class="text-muted small">Academic Portal for GC University Faisalabad Students.</p>

                    <?php if ($allowed): ?>
                        <a href="semesters.php?program=<?php echo $key; ?>" class="btn btn-custom w-100 mt-3">View Semesters</a>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100 mt-3" disabled>Locked (Enrolled Only)</button>
                    <?php endif; ?>
                </div>
              </div>
          </div>
          <?php
      }
      ?>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
  <?php include('includes/chatbot.php'); ?>
</body>
</html>