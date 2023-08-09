<?php
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

    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
        echo "File uploaded successfully.";
        // Additional processing or database storage can be added here
    } else {
        echo "Error uploading file.";
    }
}
?>
