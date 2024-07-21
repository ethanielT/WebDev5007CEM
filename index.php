<?php
include 'db_connection.php';

// Fetch all quizzes
$query = "SELECT * FROM quizzes";
$stmt = $pdo->prepare($query);
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Quiz Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Available Quizzes</h2>
        <ul>
            <?php foreach ($quizzes as $quiz): ?>
                <li>
                    <a href="take_quiz.php?id=<?php echo $quiz['id']; ?>"><?php echo htmlspecialchars($quiz['title']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>
