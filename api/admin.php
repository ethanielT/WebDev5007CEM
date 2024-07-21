<?php
include '../db_connection.php';

session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

echo json_encode(['status' => 'success']);
?>