<?php
require_once 'config.php';

// Check if user is already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        redirect('register.php', 'Please fill in all fields', 'danger');
    }

    if (strlen($password) < 8) {
        redirect('register.php', 'Password must be at least 8 characters long', 'danger');
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        redirect('register.php', 'Username or email already exists', 'danger');
    }

    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // VULNERABLE CODE: Mass Assignment Vulnerability
    // This code directly inserts all POST data without filtering
    // It allows attackers to inject additional fields like 'role'

    // Build column names and values from $_POST
    $columns = [];
    $values = [];
    $types = '';
    $params = [];

    foreach ($_POST as $key => $value) {
        if ($key === 'password') {
            // Use hashed password instead of plain text
            $columns[] = $key;
            $values[] = '?';
            $types .= 's';
            $params[] = $hashed_password;
        } else {
            // Add all other POST fields directly to the query
            $columns[] = $key;
            $values[] = '?';
            $types .= 's';
            $params[] = $value;
        }
    }

    // Create the SQL query
    $sql = "INSERT INTO users (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ")";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters dynamically
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        redirect('login.php', 'Registration successful! You can now login.', 'success');
    } else {
        redirect('register.php', 'Registration failed: ' . $conn->error, 'danger');
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Mass Assignment Vulnerability Lab</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo">Poridhi Lab</div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <?php displayMessage(); ?>

            <section class="form-container">
                <h1 class="glitch">Register</h1>
                <p>Create a new account to access the system</p>

                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required minlength="8">
                        <small>Password must be at least 8 characters long</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>

                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </form>

                <!-- Hint for the challenge -->
                <div class="hint" style="margin-top: 30px; font-size: 0.8rem; opacity: 0.7;">
                    <p>Hint: The registration process might be vulnerable to mass assignment. Can you find a way to exploit it?</p>
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
