<?php
// Path to  Python executable and AI script
$python = 'D:\\Users\\JAVERIA\\AppData\\Local\\Programs\\Python\\Python314\\python.exe';
$script = 'D:\\xampp\\htdocs\\ai_academic_portal\\ai\\predictor.py';

// Input data for testing
$input_data = json_encode([
    "total_marks" => 100,
    "obtained_marks" => 72
]);

// Prepare the command
$command = "\"$python\" \"$script\"";
$descriptor_spec = [
    0 => ["pipe", "r"],
    1 => ["pipe", "w"],
    2 => ["pipe", "w"]
];

// Execute the command
$process = proc_open($command, $descriptor_spec, $pipes);

if (is_resource($process)) {
    fwrite($pipes[0], $input_data);
    fclose($pipes[0]);

    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $error = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    proc_close($process);
} else {
    $output = "";
    $error = "Could not start the Python process.";
}

// Display results
echo "<h3>Output:</h3>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

if (!empty($error)) {
    echo "<h3>Error (if any):</h3>";
    echo "<pre>" . htmlspecialchars($error) . "</pre>";
}
?>
