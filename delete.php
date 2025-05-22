<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "123456";
$db = "product_store";
$port=3307;

$conn = new mysqli($host, $user, $password, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $image_path = $_POST["image_path"];

    // Delete image file from folder
    if (file_exists($image_path)) {
        unlink($image_path); // delete file
    }

    // Delete from database
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect back after deletion
        exit;
    } else {
        echo "❌ Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
