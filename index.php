<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h1>Login</h1>
    <form action="authenticate.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <div class="g-recaptcha" data-sitekey="6LcLlYcjAAAAAB7tSpjP5lspQdPUlZienLEde0TA"></div>
        
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
