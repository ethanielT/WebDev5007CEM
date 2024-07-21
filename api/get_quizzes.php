<?php
include '../db_connection.php';

$query = "SELECT * FROM quizzes";
$stmt = $pdo->query($query);
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($quizzes);
?>