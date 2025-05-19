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
    <div class="backgImg"> </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>

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
            <form method="post">
                <h2>Student Number</h2>
                <input type="text" id="username" name="username" placeholder="student number">

                <h2>Password</h2>
                <input type="password" id="password" name="password" placeholder="password">

                <div class="loginFeatures">
                    <div class="rememberMe">
                        <input type="checkbox" id="remember" name="remember" value="Agree">
                        <label for="terms">Remember Me</label>
                    </div>
                    <div class="forgetPass">
                        <p>Forget Pass?</p>
                    </div>
                </div>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
