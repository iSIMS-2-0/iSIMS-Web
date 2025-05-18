
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login Page</h1>
    <form action="loginTest.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>

    <?php
    require_once 'authTest.php';

    $host = '127.0.0.1';
    $db   = 'studentTest';
    $user = 'root';
    $pass = '';
    $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['username'];
        $password = $_POST['password'];
        echo "<h2>Debug: ID = $id</h2>";
        echo "<h2>Debug: Type of ID = " . gettype($id) . "</h2>";
        echo "<h2>Debug: Password = $password</h2>";
        loginUser($pdo, $id, $password);
    }
    ?>
</body>
</html>