<?php
session_start(); // Ensure this is at the top of the file
?>

<header>
    <h1><a href="index.php">Quizzard</a></h1>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="create_quiz.php">Create Quiz</a></li>
                <li><a href="logout.php">Logout</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true): ?>
                    <li><a href="admin.php">Admin Panel</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
