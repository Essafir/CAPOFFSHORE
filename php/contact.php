<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    $newItem = [
        'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
        'subject' => htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'),
        'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
        'date' => date('Y-m-d H:i:s')
    ];

    $file = 'messages.json';
    $currentMessages = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $currentMessages[] = $newItem;
    file_put_contents($file, json_encode($currentMessages, JSON_PRETTY_PRINT), LOCK_EX);

    echo json_encode([
        'status' => 'success', 
        'message' => 'Thank you! Your message has been sent successfully.'
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
?>