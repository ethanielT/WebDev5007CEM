<?php
include '../db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

//validates username by length and tells the user what's wrong
if (strlen($username) < 3 || strlen($username) > 20) {
    echo json_encode(['status' => 'error', 'message' => 'Username must be between 3 and 20 characters']);
    exit;
}

//validates the password by length and tells the user what's wrong
if (strlen($password) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters']);
    exit;
}

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$username, $hashedPassword]);

echo json_encode(['status' => 'success']);
?>
