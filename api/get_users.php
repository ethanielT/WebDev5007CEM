<?php
include '../db_connection.php';

$query = "SELECT id, username FROM users";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>
