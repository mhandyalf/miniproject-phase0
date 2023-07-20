<?php
// Database configuration
$hostname = 'localhost';
$dbname = 'handygames75';
$username = 'root';
$password = '';

// Connect to the database
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Perform basic form validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        die("Please fill all the required fields.");
    }

    if ($password !== $confirmPassword) {
        die("Password and confirm password do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        echo "Registration successful. You can now login.";
    } catch (PDOException $e) {
        die("Registration failed: " . $e->getMessage());
    }
}
?>
