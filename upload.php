<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the database
$conn = new mysqli("localhost", "root", "123456", "product_store",3307);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set
    if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_FILES["image"])) {
        $name = $_POST["name"];
        $price = $_POST["price"];

        $image = $_FILES["image"];
        $imageName = basename($image["name"]);
        $targetDir = "uploads/";
        $folder = $targetDir . $imageName;

        // Create the uploads directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($image["tmp_name"], $folder)) {
            // Insert into database
            $sql = "INSERT INTO products (name, price, image_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $name, $price, $folder);

            if ($stmt->execute()) {
                
                header("Location: index.php");
                exit;


                
            } else {
                echo "❌ DATABASE INSERT FAILED: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "❌ Error uploading image.";
        }
    } else {
        echo "❌ Required fields missing: name, price, or image.";
    }
}
else {
    echo "❌ Invalid request method.";
}


$conn->close();
?>
