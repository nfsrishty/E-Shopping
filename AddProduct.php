<?php
include "dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    if (empty($name) || empty($category) || $price <= 0 || $stock < 0) {
        echo "<div class='alert alert-danger'>Invalid input data. Please provide valid product details.</div>";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO products (name, category, price, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $name, $category, $price, $stock);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Product added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Dashboard.html">Inventory Admin Panel</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Add Product</h2>
        <form method="POST" action="addProduct.php">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" placeholder="Enter category" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter price" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter stock quantity" required>
            </div>
            <button type="submit" class="btn btn-success">Add Product</button>
        </form>
    </div>
</body>
</html>
