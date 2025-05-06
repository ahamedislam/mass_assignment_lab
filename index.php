<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mass Assignment Vulnerability Lab</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo">Poridhi Lab</div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>

        <main>
            <?php displayMessage(); ?>

            <section class="hero">
                <h1 class="glitch">Mass Assignment Vulnerability</h1>
                <p class="typing">Welcome to the Mass Assignment Vulnerability Lab.</p>
                <p>This lab demonstrates how improper handling of user input can lead to privilege escalation.</p>

                <div class="description">
                    <h2>What is Mass Assignment?</h2>
                    <p>
                        Mass Assignment is a vulnerability that occurs when an application automatically assigns user input to multiple variables or object properties without proper filtering.
                        This can allow attackers to modify fields they shouldn't have access to, such as user roles or permissions.
                    </p>

                    <h2>The Challenge</h2>
                    <p>
                        Your mission is to exploit the mass assignment vulnerability in this application to gain root access.
                        Register a new account and see if you can find a way to elevate your privileges.
                    </p>

                    <div class="buttons">
                        <?php if (!isLoggedIn()): ?>
                            <a href="register.php" class="btn btn-primary">Register</a>
                            <a href="login.php" class="btn">Login</a>
                        <?php else: ?>
                            <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> Mass Assignment Vulnerability Lab | Created for educational purposes only</p>
        </footer>
    </div>

    <script src="assets/js/effects.js"></script>
</body>
</html>
