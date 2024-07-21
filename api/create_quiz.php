<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../db_connection.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$questions = $data['questions'];
$user_id = $_SESSION['user_id'];

// Validate input
if (empty($title) || empty($questions) || !is_array($questions)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

try {
    // Insert quiz
    $query = "INSERT INTO quizzes (title, user_id) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $user_id]);
    $quiz_id = $pdo->lastInsertId();

    foreach ($questions as $question) {
        $questionText = $question['question'];
        $options = $question['options'];

        // Insert question
        $query = "INSERT INTO questions (quiz_id, question) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$quiz_id, $questionText]);
        $question_id = $pdo->lastInsertId();

        foreach ($options as $option) {
            $optionText = $option['option_text'];
            $isCorrect = $option['is_correct'] ? 1 : 0;

            // Insert option
            $query = "INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$question_id, $optionText, $isCorrect]);
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Quiz created successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
