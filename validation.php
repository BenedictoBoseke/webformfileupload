<?php
session_start();

if ($_SESSION['user_role'] !== 'Admin') {
    echo "You don't have permission to access this feature.";
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        return;
    }

    $file = $_FILES["file"];
    $allowedExtensions = ["jpeg", "jpg", "png"];
    $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Invalid file format. Only JPEG and PNG are allowed.";
        return;
    }

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "test";

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO uploads (email, filename) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $fileName);

    $fileName = basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], "uploads/" . $fileName)) {
        if ($stmt->execute()) {
            echo "File uploaded and data stored successfully.";
        } else {
            echo "Error storing data.";
        }
    } else {
        echo "Error uploading file.";
    }

    $stmt->close();
    $conn->close();
}
?>
