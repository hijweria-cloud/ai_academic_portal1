<?php
// 1. for seeing errors 
error_reporting(E_ALL);
ini_set('display_errors', 1);


$db_file = 'includes/db_connect.php';

if (file_exists($db_file)) {
    include($db_file);
} else {
    die("Error: db_connect.php file nahi mili. Path check karein.");
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // 3. Database connection check
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Check token
    $stmt = $conn->prepare("SELECT id FROM students WHERE verify_token = ? AND is_verified = 0");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Activate account
        $update = $conn->prepare("UPDATE students SET is_verified = 1, verify_token = NULL WHERE verify_token = ?");
        $update->bind_param("s", $token);
        $update->execute();

        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        echo "<h2>Email Verified Successfully! 🎉</h2>";
        echo "<p>You can login.</p>";
        echo "<a href='login.php' style='padding:10px 20px; background:#D4AF37; color:black; text-decoration:none; border-radius:5px;'>Click here to login</a>";
        echo "</div>";
    } else {
        echo "<div style='text-align:center; margin-top:50px;'>";
        echo "<h2>Invalid or expired verification link.</h2>";
        echo "<p>Shayad aapka account pehle hi verify ho chuka hai.</p>";
        echo "</div>";
    }
} else {
    echo "No token provided.";
}
?>