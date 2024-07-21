<?php
session_start();
include '../db_connection.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['id']) ? $_POST['id'] : '';

    if (empty($user_id)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'No user ID provided.']);
        exit();
    }

    try {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting the user.']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>