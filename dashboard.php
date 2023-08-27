<?php
session_start();

if ($_SESSION['user_role'] === 'admin') {
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>File Upload and Email Validation</title>
        </head>
        <body>
            <h1>Upload a File and Enter Email</h1>
            <form action="validation.php" method="POST" enctype="multipart/form-data">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="file">File (JPEG/PNG only):</label>
                <input type="file" id="file" name="file" accept=".jpeg, .jpg, .png" required><br><br>

                <input type="submit" value="Upload and Submit">
            </form>
        </body>
        </html>';
} else {
    echo "You don't have permission to access this feature.";
}
?>
