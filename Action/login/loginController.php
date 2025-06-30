<?php
session_start();
require_once '../../Config/connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    // Query from database
    $sql = "SELECT * FROM user WHERE userName = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a matching user found
    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Match password (plain text comparison)
        if ($password === $row['Pwd']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['userName'];

            if ($remember) {
                setcookie('remember', $username, time() + (86400 * 30), "/"); // 30 days
            } else {
                setcookie('remember', '', time() - 3600, "/");
            }

            header('Location:/HR_SYSTEM/index.php'); // Redirect to index page
            exit;
        }
    }

    // Invalid credentials
    $error = "Invalid username or password.";
}


// Check for remembered user
$remembered_user = $_COOKIE['remember'] ?? '';
?>

