<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/header.css">
    <link rel="stylesheet" href="/public/assets/CSS/login.css">
    <title>Document</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
        <h1>Login Page</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
