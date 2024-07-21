<!DOCTYPE html>
<html>
<head>
    <title>Register - Quiz Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Register</h1>
    <form id="registerForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <button type="submit">Register</button>
    </form>
    <div id="registerError" class="error"></div>
    <script src="js/script.js"></script>
</body>
</html>
