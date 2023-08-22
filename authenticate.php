<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "test";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (password_verify($password, $row['password'])) {
    $_SESSION['user_role'] = $row['role'];
    header("Location: dashboard.php");
} else {
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>
