<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request.');
}

$quiz_id = $_POST['quiz_id'];
$user_id = $_SESSION['user_id'];
$score = 0;

// Fetch quiz questions
$query = "SELECT * FROM questions WHERE quiz_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($questions as $question) {
    $question_id = $question['id'];

    // Fetch the correct answer for the question
    $query = "SELECT id FROM options WHERE question_id = ? AND is_correct = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$question_id]);
    $correct_option = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($correct_option && isset($_POST["question_$question_id"]) && $_POST["question_$question_id"] == $correct_option['id']) {
        $score++;
    }
}

// Insert result into the database
$query = "INSERT INTO results (user_id, quiz_id, score) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id, $quiz_id, $score]);

// Redirect to results page or show results
echo "You scored $score out of " . count($questions);
?>
