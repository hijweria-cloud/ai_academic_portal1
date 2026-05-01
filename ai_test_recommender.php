<?php
$python = 'D:\\Users\\JAVERIA\\AppData\\Local\\Programs\\Python\\Python314\\python.exe';
$script = 'D:\\xampp\\htdocs\\ai_academic_portal\\ai\\recommender.py';

// Test input data
$input_data = json_encode([
    "subject" => "Artificial Intelligence",
    "percentage" => 57
]);

$command = "\"$python\" \"$script\"";
$descriptor_spec = [
    0 => ["pipe", "r"],
    1 => ["pipe", "w"],
    2 => ["pipe", "w"]
];

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

echo "<h3>Output:</h3><pre>" . htmlspecialchars($output) . "</pre>";

if (!empty($error)) {
    echo "<h3>Error (if any):</h3><pre>" . htmlspecialchars($error) . "</pre>";
}
?>
