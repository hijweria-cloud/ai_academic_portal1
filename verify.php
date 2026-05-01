<?php
include('includes/db_connect.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check token
    $stmt = $conn->prepare("SELECT id FROM students WHERE verify_token = ? AND is_verified = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Activate account
        $update = $conn->prepare("UPDATE students SET is_verified = 1, verify_token = NULL WHERE verify_token = ?");
        $update->bind_param("s", $token);
        $update->execute();

        echo "<h2>Email Verified Successfully! 🎉</h2>";
        echo "<a href='login.php'>Click here to login</a>";
    } else {
        echo "Invalid or expired verification link.";
    }
}
?>
