<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password = "123456";  // use '123456' or whatever your password is
$db = "product_store";
$port = 3307;

$conn = new mysqli($host, $user, $password, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["id"];
$name = $_POST['name'];
$emailid = $_POST['emailid'];
$password = $_POST['password'];
$confirmpass = $_POST['confirmpass'];

// Password match check
if ($password !== $confirmpass) {
    die("Error: Passwords do not match.");
}

// Hash the password
$hashedpass = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$sql = "INSERT INTO students (id, name, emailid, password, confirmpass) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if preparation was successful
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

// Bind the parameters
$stmt->bind_param("issss", $id, $name, $emailid, $hashedpass, $hashedpass);

// Execute the statement
if ($stmt->execute()) {

    echo "<script>
        alert('User registered successfully!');
        window.location.href = 'login.html';
    </script>";

} else {
    echo "Execution error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
