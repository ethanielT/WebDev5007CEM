<!DOCTYPE html>
<html>
<head>
    <title>Login - Quiz Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <div id="loginError" class="error"></div>
    <script src="js/script.js"></script>
</body>
</html>
