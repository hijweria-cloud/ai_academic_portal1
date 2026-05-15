<?php 
session_start();
include('includes/db_connect.php'); // Step 1: Database connection include ki

if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Step 2: Fetch Real-time stats for Sir's review requirement
$student_count = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];
$program_count = $conn->query("SELECT COUNT(*) as total FROM programs")->fetch_assoc()['total']; // Ensure 'programs' table exists
$marks_count = $conn->query("SELECT COUNT(*) as total FROM marks")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel | GC University Faisalabad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #FAF3E0; color: #1C1C1C; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar { background: #1C1C1C; padding: 0.8rem; }
        .navbar-brand { font-weight: 700; color: #D4AF37 !important; }
        .nav-link { color: #F5EBDD !important; font-weight: 500; }
        .dashboard { flex: 1; padding: 60px 0; }
        h2 { font-weight: 700; margin-bottom: 40px; color: #1C1C1C; }
        
        /* Stats Cards */
        .stat-card { background: #1C1C1C; color: #D4AF37; border-radius: 15px; padding: 20px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .stat-card h3 { font-size: 2.5rem; font-weight: 800; margin: 0; }
        .stat-card p { color: #F5EBDD; margin: 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }

        .card { background: #fff; border-radius: 18px; box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1); transition: 0.3s; border: 1px solid rgba(212, 175, 55, 0.2); height: 100%; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3); }
        .btn-custom { background-color: #D4AF37; color: #1C1C1C; border-radius: 8px; font-weight: 600; border: none; width: 100%; padding: 10px; }
        .btn-custom:hover { background-color: #1C1C1C; color: #D4AF37; }
        footer { background: #1C1C1C; text-align: center; padding: 20px; color: #D4AF37; }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">AI ACADEMIC PORTAL | ADMIN</a>
            <div class="ms-auto">
                <a class="btn btn-outline-warning btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container dashboard text-center">
        <h2>Administrative Overview</h2>

        <div class="row mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $student_count; ?></h3>
                    <p>Total Students</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $program_count; ?></h3>
                    <p>Active Programs</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $marks_count; ?></h3>
                    <p>Marks Entries</p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h5>Student Management</h5>
                    <p class="text-muted small">Approve new signups, edit profiles, or remove student records from the portal.</p>
                    <a href="manage_students.php" class="btn btn-custom mt-auto">Manage Students</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <h5>Academic Structure</h5>
                    <p class="text-muted small">Configure semester subjects and map programs to institutional standards.</p>
                    <a href="manage_semesters.php" class="btn btn-custom mt-auto">Configure Academics</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <h5>System Programs</h5>
                    <p class="text-muted small">Update or delete degree programs according to GCUF department changes.</p>
                    <a href="manage_programs.php" class="btn btn-custom mt-auto">Manage Programs</a>
                </div>
            </div>
        </div>
    </div>

    <footer>© 2026 GC University Faisalabad | AI-Based Academic Portal</footer>

    <div id="chatbot-icon" style="position:fixed; bottom:25px; right:25px; width:60px; height:60px; background:#1C1C1C; border-radius:50%; display:flex; justify-content:center; align-items:center; cursor:pointer; color:#D4AF37; font-size:24px; box-shadow:0 4px 10px rgba(0,0,0,0.3);">💬</div>
</body>
</html>