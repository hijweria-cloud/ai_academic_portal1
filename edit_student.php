<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_students.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch current student info
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: manage_students.php");
    exit();
}

// Update student info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $program = trim($_POST['program']);
    $semester = (int)$_POST['semester'];

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, program=?, semester=? WHERE id=?");
    $stmt->bind_param("sssii", $name, $email, $program, $semester, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_students.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student | Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      color: #1C1C1C;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .navbar {
      background-color: #1C1C1C;
    }
    .navbar-brand {
      color: #D4AF37 !important;
      font-weight: 700;
    }
    .navbar .nav-link {
      color: #F5EBDD !important;
    }
    .navbar .nav-link:hover {
      color: #D4AF37 !important;
    }
    .edit-card {
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      margin: 60px auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      border-top: 4px solid #D4AF37;
      max-width: 600px;
    }
    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      border: none;
      border-radius: 8px;
      font-weight: 600;
    }
    .btn-custom:hover {
      background-color: #B9962F;
      color: #fff;
    }
    footer {
      background-color: #1C1C1C;
      color: #F5EBDD;
      text-align: center;
      padding: 10px 0;
      margin-top: auto;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="admin_dashboard.php">AI Academic Portal</a>
    <div class="navbar-nav ms-auto">
      <a class="nav-link" href="manage_students.php">Back</a>
    </div>
  </div>
</nav>

<div class="edit-card">
  <h3 class="text-center mb-4" style="color:#D4AF37;">Edit Student</h3>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Program</label>
      <input type="text" name="program" value="<?php echo htmlspecialchars($student['program']); ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Semester</label>
      <select name="semester" class="form-select" required>
        <?php for($i=1;$i<=8;$i++){ 
          $selected = $i == $student['semester'] ? 'selected' : '';
          echo "<option value='$i' $selected>$i</option>"; 
        } ?>
      </select>
    </div>
    <button type="submit" class="btn btn-custom w-100">Update Student</button>
  </form>
</div>

<footer>
  <p>&copy; <?php echo date('Y'); ?> AI Academic Portal. All Rights Reserved.</p>
</footer>
</body>
</html>
