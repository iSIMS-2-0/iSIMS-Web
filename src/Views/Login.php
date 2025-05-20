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
    <div class="backgImg"> </div>

    <div class="logInContainer">
        <div class="title">
            <h1>Login</h1>
        </div>

        <div class="userCredentials">
            <?php if (!empty($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if (!empty($message)): ?>
                <p style="color:green;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <form method="post" id="login_form">
                <div class="student_number">
                    <label for="Student Number">Student Number</label>
                    <input type="text" id="username" name="username" placeholder="student number">
                </div>

                <div class="password">
                    <label for="Password">Password</label>
                    <input type="password" id="password" name="password" placeholder="password">
                </div>

                <div class="login_features">
                    <div class="remember_me">
                        <input type="checkbox" id="remember" name="remember" value="Agree">
                        <label for="terms">Remember Me</label>
                    </div>
                    <div class="forget_password">
                        <a href="#">Forget Pass?</a>
                    </div>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>