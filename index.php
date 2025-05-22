<?php
session_start();
$conn = new mysqli("localhost", "root", "", "product_store", 3307);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>CHITKART - Product Listing</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fdf7f2;
      padding: 20px;
    }

    .product-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
      max-width: 1100px;
      margin: auto;
    }

    .product {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      text-align: center;
    }

    .product img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
    }

    .product h3 {
      margin: 10px 0 5px;
    }

    .product p {
      color: #555;
    }

    .cart-link {
      display: block;
      text-align: right;
      margin-bottom: 20px;
      font-weight: bold;
      color: #b31217;
      text-decoration: none;
    }

    .add-btn {
      background: #b31217;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .add-btn:hover {
      background-color: #880d13;
    }
  </style>
</head>
<body>

  <a href="viewcart1.php" class="cart-link">🛒 Go to Cart</a>

  <div class="product-container">
    <?php
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo '<div class="product">';
        echo '<img src="' . $row["image_path"] . '" alt="' . $row["name"] . '">';
        echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
        echo '<p>₹' . number_format($row["price"], 2) . '</p>';
        echo '<form method="post" action="add_to_cart.php">';
        echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
        echo '<input type="hidden" name="name" value="' . htmlspecialchars($row["name"]) . '">';
        echo '<input type="hidden" name="price" value="' . $row["price"] . '">';
        echo '<input type="hidden" name="product_image" value="' . $row["image_path"] . '">';
        echo '<button type="submit" class="add-btn">Add to Cart</button>';
        echo '</form>';
        echo '</div>';
      }
    } else {
      echo "<p>No products found.</p>";
    }
    ?>
  </div>

</body>
</html>