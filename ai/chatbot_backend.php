<?php
header("Content-Type: text/plain");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = $_POST['message'] ?? '';

    $api_key = "AIzaSyBDkJD9b_30-AlxlRrVXvdgsyCNiH04Jak";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $api_key;

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $user_message]
                ]
            ]
        ]
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/json\r\n",
            "method" => "POST",
            "content" => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo "Error connecting to AI server.";
        exit;
    }

    $response = json_decode($result, true);
    $reply = $response['candidates'][0]['content']['parts'][0]['text'] ?? "Sorry, I didn’t get that.";
    echo $reply;
}
?>
