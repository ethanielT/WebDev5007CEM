<?php
session_start(); // Ensure this is at the top of the file

// Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
    header('Location: login.php'); // Redirect to login or another page
    exit();
}

// Other admin page content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Quiz Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Admin Panel</h1>
    <div>
        <h2>Delete User</h2>
        <form id="deleteUserForm">
            <label for="userId">Select User:</label>
            <select id="userId" name="userId" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <button type="button" id="deleteUserButton">Delete User</button>
        </form>
    </div>
    <div>
        <h2>Delete Quiz</h2>
        <form id="deleteQuizForm">
            <label for="quizId">Select Quiz:</label>
            <select id="quizId" name="quizId" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <button type="button" id="deleteQuizButton">Delete Quiz</button>
        </form>
    </div>
    <script src="js/admin.js"></script>
</body>
</html>