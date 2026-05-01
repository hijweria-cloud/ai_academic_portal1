<?php 
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Add student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $program = trim($_POST['program']);
    $semester = (int)$_POST['semester'];
    $default_password = '12345';

    $stmt = $conn->prepare("INSERT INTO students (name, email, password, program, semester) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $email, $default_password, $program, $semester);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_students.php");
    exit();
}

// Delete student
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_students.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Students | Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      color: #1C1C1C;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      text-align: center;
    }

    .container-main {
      flex: 1;
      padding-top: 30px;
      padding-bottom: 20px;
      max-width: 1100px;
      margin: 0 auto;
    }

    h3 {
      color: #1C1C1C;
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 1.4rem;
    }

    .card-form {
      border-radius: 10px;
      background: #fff;
      padding: 15px 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-top: 3px solid #D4AF37;
      text-align: left;
    }

    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      padding: 6px 12px;
      font-size: 14px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #B9962F;
      color: #fff;
    }

    .table {
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      margin-top: 15px;
      font-size: 14px;
    }

    thead.table-dark th {
      background-color: #1C1C1C;
      color: #F5EBDD;
      border: none;
      padding: 8px;
    }
    tbody td {
      padding: 6px 10px;
    }
    tbody tr:hover {
      background-color: #F9F3E7;
    }

    .small {
      font-size: 13px;
      color: #666;
    }

    footer {
      background-color: #1C1C1C;
      color:  #D4AF37;
      text-align: center;
      padding: 8px 0;
      margin-top: auto;
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

<!-- Include Navbar from header.php -->
<?php include('includes/header.php'); ?>

<!-- Main Content -->
<div class="container-main">
  <h3>Manage Students</h3>

  <div class="card card-form mb-3">
    <form method="POST" class="row g-2 align-items-center">
      <div class="col-md-3">
        <input name="name" class="form-control form-control-sm" placeholder="Full name" required>
      </div>
      <div class="col-md-3">
        <input name="email" type="email" class="form-control form-control-sm" placeholder="Email" required>
      </div>
      <div class="col-md-2">
        <input name="program" class="form-control form-control-sm" placeholder="Program (e.g. BSCS)" required>
      </div>
      <div class="col-md-2">
        <select name="semester" class="form-select form-select-sm" required>
          <?php for($i=1;$i<=8;$i++){ echo "<option value='$i'>$i</option>"; } ?>
        </select>
      </div>
      <div class="col-md-2 text-end">
        <button name="add_student" class="btn btn-custom w-100">Add</button>
      </div>
    </form>
    <div class="small mt-1">
      Default password for new students: <strong>12345</strong>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Program</th>
          <th>Semester</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $res = $conn->query("SELECT id, name, email, program, semester FROM students ORDER BY id DESC");
          while ($r = $res->fetch_assoc()) {
              echo "<tr>
                      <td>{$r['id']}</td>
                      <td>".htmlspecialchars($r['name'])."</td>
                      <td>".htmlspecialchars($r['email'])."</td>
                      <td>".htmlspecialchars($r['program'])."</td>
                      <td>{$r['semester']}</td>
                      <td>
                        <a class='btn btn-sm btn-outline-dark' href='edit_student.php?id={$r['id']}'>Edit</a>
                        <a class='btn btn-sm btn-danger' href='manage_students.php?delete={$r['id']}' onclick=\"return confirm('Delete this student?')\">Delete</a>
                      </td>
                    </tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<footer>
  <p>&copy; <?php echo date('Y'); ?> AI Academic Portal. All Rights Reserved.</p>
</footer>
<?php include('includes/chatbot.php'); ?>

</body>
</html>
