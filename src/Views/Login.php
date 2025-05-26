<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <section class="background_image"></section>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <main class="login_container">
        <header class="title">
            <h1>Login</h1>
        </header>

        <section class="user_credentials">
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            
            <?php if (!empty($message)): ?>
                <p style="color:green;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="post" id="login_form">
                <div class="username_field">
                    <label for="username">Student Number</label>
                    <input type="text" id="username" name="username" placeholder="student number" required>
                </div>

                <div class="password_field">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="password" required>
                        <button type="button" id="togglePassword" class="toggle-password">
                            <i class="fa-solid fa-eye"></i> <!-- Font Awesome icon -->
                        </button>
                    </div>
                </div>

                <div class="login_features">
                    <div class="remember_me">
                        <input type="checkbox" id="remember" name="remember" value="Agree">
                        <label for="remember">Remember Me</label>
                    </div>

                    <div class="forget_password">
                        <a href="#">Forget Password?</a>
                    </div>
                </div>
                 
                <button type="submit" class="submit">Submit</button>
            </form>

        </section>

    </main>
    <script defer src="/public/assets/JavaScript/login.js"></script>
</body>
</html>