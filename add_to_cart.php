<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all expected fields are present
    if (isset($_POST["id"], $_POST["name"], $_POST["price"], $_POST["product_image"])) {
        $product = [
            "id" => $_POST["id"],
            "name" => $_POST["name"],
            "price" => $_POST["price"],
            "image" => $_POST["image"],
            "quantity" => 1
        ];

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        $found = false;

        // Check if product already in cart
        foreach ($_SESSION["cart"] as &$item) {
            if ($item["id"] == $product["id"]) {
                $item["quantity"]++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION["cart"][] = $product;
        }

        // Redirect to cart page
        header("Location:viewcart1.php");
        exit;
    } else {
        echo "❌ Required product data missing.";
    }
} else {
    echo "❌ Invalid request method.";
}
?>
