<?php
session_start();
include('includes/db_connect.php'); 
include('includes/header.php');

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Database se G1 aur Absences auto-fetch karna
$sql = "SELECT mid_obtained, absences FROM marks 
        WHERE student_id = '$student_id' 
        ORDER BY id DESC LIMIT 1";
$res = mysqli_query($conn, $sql);
$db_data = mysqli_fetch_assoc($res);

$default_g1 = $db_data['mid_obtained'] ?? 0;
$default_absences = $db_data['absences'] ?? 0;

$prediction_data = null;
$debug_error = ""; 

if (isset($_POST['predict_now'])) {
    $python = 'D:\Users\JAVERIA\AppData\Local\Programs\Python\Python310\python.exe';
    $script = 'D:\xampp\htdocs\ai_academic_portal - Copy\ai\predictor.py';
    
    // Inputs ko sanitize karna
    $g1 = escapeshellarg($_POST['g1']);
    $g2 = escapeshellarg($_POST['g2']);
    $study = escapeshellarg($_POST['studytime']);
    $fail = escapeshellarg($_POST['failures']);
    $abs = escapeshellarg($_POST['absences']);

    // Python execute karna
    $command = "\"$python\" \"$script\" $g1 $g2 $study $fail $abs 2>&1";
    $output = shell_exec($command);
    
    // Result decode karna
    $prediction_data = json_decode($output, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $debug_error = $output; // Agar JSON ghalat hai to error save karna
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Course Forecast | Academic Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #FAF3E0; font-family: 'Poppins', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
        .content-wrapper { flex: 1 0 auto; }
        .card { border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: none; }
        .btn-custom { background-color: #D4AF37; color: #1C1C1C; font-weight: 600; border: none; padding: 10px 20px; border-radius: 8px; transition: 0.3s; }
        .btn-custom:hover { background-color: #B9962F; color: #fff; transform: translateY(-2px); }
        .result-box { background: #fff; border-left: 8px solid #D4AF37; border-radius: 15px; padding: 30px; min-height: 350px; }
        footer { flex-shrink: 0; }
    </style>
</head>
<body>

<div class="content-wrapper">
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold" style="color: #B8860B;">AI Course Performance Forecast</h1>
            <p class="text-muted">Analyze course performance using Decision Tree Models.</p>
        </div>

        <?php if ($debug_error && !strpos($debug_error, 'UserWarning')): ?>
            <div class="alert alert-danger mx-auto" style="max-width: 800px;">
                <strong>System Debug Info:</strong> <br>
                <code><?= htmlspecialchars($debug_error) ?></code>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card p-4">
                    <h5 class="fw-bold mb-3">Input Course Data</h5>
                    <form method="POST">
                        <label class="fw-bold small">Mid-term Marks (G1):</label>
                        <input type="number" name="g1" class="form-control mb-3" value="<?= $default_g1 ?>" min="0" max="20" required>
                        
                        <label class="fw-bold small">Internal Marks (G2):</label>
                        <input type="number" name="g2" class="form-control mb-3" placeholder="Enter 0-20" min="0" max="20" required>
                        
                        <label class="fw-bold small">Study Time:</label>
                        <select name="studytime" class="form-select mb-3">
                            <option value="1"> < 2 hours</option>
                            <option value="2" selected>2-5 hours</option>
                            <option value="3">5-10 hours</option>
                            <option value="4"> > 10 hours</option>
                        </select>

                        <label class="fw-bold small">Failures:</label>
                        <select name="failures" class="form-select mb-3">
                            <option value="0">None</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>

                        <label class="fw-bold small">Total Absences:</label>
                        <input type="number" name="absences" class="form-control mb-3" value="<?= $default_absences ?>">

                        <button type="submit" name="predict_now" class="btn btn-custom w-100">Generate AI Report</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <?php if ($prediction_data && isset($prediction_data['status']) && $prediction_data['status'] == 'success'): ?>
                    <div class="result-box shadow">
                        <h5 class="text-muted fw-bold">Forecasted Course GPA</h5>
                        <h1 class="display-2 fw-bold" style="color: #D4AF37;"><?= number_format($prediction_data['predicted_gpa'], 2) ?></h1>
                        
                        <div class="progress mb-4" style="height: 15px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 style="width: <?= ($prediction_data['predicted_gpa']/4)*100 ?>%; background-color: #D4AF37;"></div>
                        </div>
                        
                        <p class="mb-0"><strong>Status:</strong> Decision Tree Analysis Complete.</p>
                        <hr>
                        <p class="small text-muted">This AI forecast helps in identifying weak performance areas early.</p>
                    </div>
                <?php else: ?>
                    <div class="card p-5 text-center text-muted d-flex align-items-center justify-content-center" style="min-height: 350px;">
                        <div>
                            <div style="font-size: 50px;">🤖</div>
                            <p class="mt-3">Ready to analyze. Please fill the data.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<?php include('includes/chatbot.php'); ?>

</body>
</html>