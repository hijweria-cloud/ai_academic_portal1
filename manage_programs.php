<?php
session_start();
require_once 'includes/db_connect.php';
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Add program
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_program'])) {
    $program_name = trim($_POST['program_name']);
    $description = trim($_POST['description']);

    $stmt = $conn->prepare("INSERT INTO programs (program_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $program_name, $description);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_programs.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM programs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_programs.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Programs | Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      color: #1C1C1C;
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar {
      background-color: #1C1C1C;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      height: 52px;
      padding: 0 15px !important;
      display: flex;
      align-items: center;
      z-index: 2;
    }

    .navbar .navbar-brand {
      color: #D4AF37 !important;
      font-weight: 600;
      font-size: 1.05rem;
      margin: 0;
      padding: 0;
    }

    .navbar .nav-link {
      color: #F5EBDD !important;
      font-size: 0.9rem;
      font-weight: 500;
      margin-left: 15px;
      padding: 0 !important;
    }

    .nav-link:hover {
      color: #D4AF37 !important;
    }

    /* Container and title */
    .container {
      position: relative;
      z-index: 1;
      padding-top: 80px;
      padding-bottom: 60px;
      animation: fadeIn 0.8s ease-in-out;
    }

    h3 {
      color: #1C1C1C;
      margin-top: 18px;
      font-weight: 700;
      text-align: center;
    }

    /* Card */
    .card {
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    /* Buttons */
    .btn-custom {
      background: #D4AF37;
      color: #1C1C1C;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background: #B9962F;
      color: #F5EBDD;
      transform: scale(1.05);
    }

    .btn-danger {
      background: #8B0000 !important;
      border: none;
    }

    .btn-danger:hover {
      background: #A52A2A !important;
    }

    /* Table */
    .table {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .table thead {
      background-color: #1C1C1C;
      color: #D4AF37;
      font-weight: 600;
    }

    /* Smooth fade-in */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="admin_dashboard.php">AI Academic Portal</a>
    <div>
      <a class="nav-link d-inline" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container">
  <h3>Manage Programs</h3>

  <div class="card p-3 mb-4 mt-4">
    <form method="POST" class="row g-2 align-items-center">
      <div class="col-md-5">
        <input name="program_name" class="form-control" placeholder="Program name (e.g. BS Computer Science)" required>
      </div>
      <div class="col-md-5">
        <input name="description" class="form-control" placeholder="Short description (optional)">
      </div>
      <div class="col-md-2">
        <button name="add_program" class="btn btn-custom w-100">Add</button>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Program Name</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $res = $conn->query("SELECT id, program_name, description FROM programs ORDER BY id DESC");
          if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) {
              echo "<tr>
                      <td>{$r['id']}</td>
                      <td>".htmlspecialchars($r['program_name'])."</td>
                      <td>".htmlspecialchars($r['description'])."</td>
                      <td>
                        <a class='btn btn-sm btn-danger' href='manage_programs.php?delete={$r['id']}' onclick=\"return confirm('Delete this program?')\">Delete</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No programs found.</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

  <?php include('includes/footer.php'); ?>
  <?php include('includes/chatbot.php'); ?>

</body>
</html>
