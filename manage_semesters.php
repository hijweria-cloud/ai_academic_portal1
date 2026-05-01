<?php
session_start();
require_once 'includes/db_connect.php';
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Add semester
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_semester'])) {
    $name = trim($_POST['name']);
    $stmt = $conn->prepare("INSERT INTO semesters (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_semesters.php");
    exit();
}

// Delete semester
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM semesters WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_semesters.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Semesters | Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Making body a flex container to push footer down */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      color: #1C1C1C;
    }

    /* Keeping  original container spacing */
    .container {
      padding-top: 90px;
      padding-bottom: 60px;
    }

    /* Navbar */
    .navbar {
      background-color: #1C1C1C !important;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      height: 55px;
      display: flex;
      align-items: center;
      z-index: 10;
    }

    .navbar-brand {
      color: #D4AF37 !important; /* Gold */
      font-weight: 700;
      letter-spacing: 0.5px;
      font-size: 1.3rem;
      transition: color 0.3s ease;
    }

    .nav-link {
      color: #F5EBDD !important;
      font-weight: 500;
      margin-left: 15px;
      font-size: 0.95rem;
    }

    .nav-link:hover {
      color: #D4AF37 !important;
    }

    h3 {
      color: #1C1C1C;
      font-weight: 700;
      text-align: center;
      margin-bottom: 30px;
    }

    .card {
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      background: #fff;
      border-top: 5px solid #D4AF37;
    }

    .btn-custom {
      background: #D4AF37;
      color: #1C1C1C;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
    }

    .btn-custom:hover {
      background: #B9962F;
      color: #F5EBDD;
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(185, 150, 47, 0.5);
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
    }

    /* Footer */
    footer {
      background-color: #1C1C1C !important;
      color: #D4AF37 !important;
      text-align: center;
      padding: 15px 0;
      width: 100%;
      margin-top: auto; /* ensures it sticks to bottom */
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container-fluid d-flex justify-content-between align-items-center px-3">
    <a class="navbar-brand" href="admin_dashboard.php">AI Academic Portal</a>
    <div>
      <a class="nav-link d-inline" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container">
  <h3>Manage Semesters</h3>

  <div class="card p-3 mb-4 mt-4">
    <form method="POST" class="row g-2">
      <div class="col-md-10">
        <input name="name" class="form-control" placeholder="Semester name e.g. Semester 1" required>
      </div>
      <div class="col-md-2">
        <button name="add_semester" class="btn btn-custom w-100">Add</button>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Semester Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $res = $conn->query("SELECT id, name FROM semesters ORDER BY id DESC");
          if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) {
              echo "<tr>
                      <td>{$r['id']}</td>
                      <td>".htmlspecialchars($r['name'])."</td>
                      <td>
                        <a class='btn btn-sm btn-danger' href='manage_semesters.php?delete={$r['id']}' onclick=\"return confirm('Delete this semester?')\">Delete</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No semesters found.</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Footer -->
<footer>
  © 2025 Aspire College | AI-Based Academic Portal
</footer>

<?php include('includes/chatbot.php'); ?>

</body>
</html>
