<?php
require_once 'config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php', 'Please login to access the dashboard', 'info');
}

// Get user information
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Check if user exists in database (in case session is manipulated)
$stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // User not found, clear session and redirect
    session_destroy();
    redirect('login.php', 'Session expired. Please login again.', 'info');
}

$user = $result->fetch_assoc();
$stmt->close();

// Update session with latest data from database
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];

$username = $user['username'];
$email = $user['email'];
$role = $user['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Mass Assignment Vulnerability Lab</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo">Poridhi Lab</div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <?php displayMessage(); ?>

            <section class="dashboard">
                <h1 class="glitch">User Dashboard</h1>

                <div class="user-info">
                    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p>Email: <?php echo htmlspecialchars($email); ?></p>
                    <p>Role: <span style="color: <?php echo $role === 'root' ? 'var(--success-color)' : 'var(--text-color)'; ?>">
                        <?php echo htmlspecialchars($role); ?>
                    </span></p>
                </div>

                <?php if ($role === 'root'): ?>
                    <div class="success-message">
                        <h2>🎉 Congratulations! Lab Solved! 🎉</h2>
                        <p class="js-typing" data-text="You have successfully exploited the mass assignment vulnerability!"></p>

                        <div class="explanation" style="margin-top: 30px; border: 1px solid var(--success-color); padding: 20px;">
                            <h3>Explanation:</h3>
                            <p>
                                You successfully exploited a mass assignment vulnerability in the registration process.
                                The application directly inserted all POST parameters into the database without filtering,
                                allowing you to set the 'role' field to 'root' even though it wasn't part of the form.
                            </p>
                            <p>
                                In a real application, this could allow attackers to escalate privileges, modify sensitive data,
                                or bypass security controls.
                            </p>
                            <h3>How to fix this vulnerability:</h3>
                            <p>
                                1. Explicitly define which fields are allowed to be set by users<br>
                                2. Use a whitelist approach instead of directly inserting all POST data<br>
                                3. Implement proper access controls for sensitive fields<br>
                                4. Validate and sanitize all user input
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="challenge-info">
                        <h3>Challenge Status: Not Completed</h3>
                        <p>You need to find a way to gain root access to complete this challenge.</p>
                        <p>Hint: Look at how the registration process works. Can you manipulate it?</p>
                    </div>
                <?php endif; ?>
            </section>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> Mass Assignment Vulnerability Lab | Created for educational purposes only</p>
        </footer>
    </div>

    <script src="assets/js/effects.js"></script>
</body>
</html>
