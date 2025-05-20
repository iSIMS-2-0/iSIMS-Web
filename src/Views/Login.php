<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/header.css">
    <link rel="stylesheet" href="/public/assets/CSS/login.css">
    <title>Student Access Module</title>
</head>
<body>
    <div class="background_image"> </div>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>

    <main class="main_content">
        <div class="login_container">
            <div class="title">
                <h1>Login</h1>
            </div>

            <form method="post" id="login_form">
                <?php if (!empty($error)): ?>
                    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                
                <?php if (!empty($message)): ?>
                    <p style="color:green;"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>

                <label for="Student Number">Student Number</label>
                <input type="text" id="username" name="username" placeholder="student number">
                    
                <label for="Password">Password</label>
                <input type="password" id="password" name="password" placeholder="password">

                 <div class="login_features">
                    <div class="remember_me">
                        <input type="checkbox" id="remember" name="remember" value="Agree">
                        <label for="terms">Remember Me</label>
                    </div>
                    <div class="forget_password">
                        <p>Forget Pass?</p>
                    </div>
                </div>
                
                <button type="submit" class="button">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>