<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Login/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/login.js"></script>
    <title>Login</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <section class="backgroundImage"></section>

    <main class="loginContainer">
        <div class="title">
            <h1>Login</h1>
        </div>

        <section class="userCredentials">
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            
            <?php if (!empty($message)): ?>
                <p style="color:green;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="post" id="loginForm">
                <div class="usernameField">
                    <label for="username">Student Number</label>
                    <input type="text" id="username" name="username" placeholder="student number" required>
                </div>

               <div class="password_field">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="password" required>
                        <button type="button" id="togglePassword" class="toggle-password">
                            <i class="fa-solid fa-eye"></i> 
                        </button> 
                    </div>
                </div>

                <div class="loginOptions">
                    <div class="rememberMe">
                        <input type="checkbox" id="remember" name="remember" value="Agree">
                        <label for="remember">Remember Me</label>
                    </div>

                    <div class="forgotPassword">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit" class="submit">Submit</button>
            </form>
        </section>
    </main>
</body>
</html>