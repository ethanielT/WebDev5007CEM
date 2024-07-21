<?php
session_start();
include '../db_connection.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

/*function debugToConsole($msg) {
        echo "<script>console.log(".json_encode($msg).")</script>";
}
debugToConsole($_SERVER['REQUEST_METHOD']);

implode($_POST);*/
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $quiz_id = isset($_POST['id']) ? $_POST['id'] : '';

    if (empty($quiz_id)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'No quiz ID provided.']);
        exit();
    }

    try {
        $query = "DELETE FROM quizzes WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$quiz_id]);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Quiz deleted successfully.']);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting the quiz.']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
