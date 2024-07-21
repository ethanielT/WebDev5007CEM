<?php
session_start();
include 'db_connection.php';

if (!isset($_GET['id'])) {
    die('Quiz ID not provided.');
}

$quiz_id = $_GET['id'];

// Fetch quiz data
$query = "SELECT * FROM quizzes WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$quiz_id]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    die('Quiz not found.');
}

// Fetch quiz questions
$query = "SELECT * FROM questions WHERE quiz_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($quiz['title']); ?> - Take Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main id="mainContent">
        <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
        <form id="takeQuizForm" method="post">
            <?php $questionNumber = 1; ?>
            <?php foreach ($questions as $question): ?>
                <div class="question">
                    <p><?php echo $questionNumber, '. ', htmlspecialchars($question['question']); ?></p>
                    <?php
                    // Fetch question options
                    $query = "SELECT * FROM options WHERE question_id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$question['id']]);
                    $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($options as $option): ?>
                        <div>
                            <input type="radio" name="question_<?php echo $question['id']; ?>" value="<?php echo $option['id']; ?>" required>
                            <label><?php echo htmlspecialchars($option['option_text']); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <br>
                <?php $questionNumber++; ?>
            <?php endforeach; ?>
            <button type="submit">Submit Quiz</button>
        </form>
    </main>
    <script src="js/script.js"></script>
</body>
</html>



