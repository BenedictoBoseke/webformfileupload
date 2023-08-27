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

// reCAPTCHA
$recaptcha_secret = '6LcLlYcjAAAAAFIF9DMVdhXXQIh_kjpv605FygNf';
$recaptcha_response = $_POST['g-recaptcha-response'];

$verification_url = 'https://www.google.com/recaptcha/api/siteverify';
$verification_data = array(
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
);

$ch = curl_init($verification_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($verification_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response);

if (!$result->success) {
    die("reCAPTCHA verification failed");
}

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
