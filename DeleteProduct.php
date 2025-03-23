<?php
include "dbconnect.php"; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $product_id = intval($_POST['id']); // Sanitize and ensure it's an integer

        // Check if the product exists
        $check_sql = "SELECT id FROM products WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $product_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Delete the product
            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);

            if ($stmt->execute()) {
                echo "<script>alert('Product deleted successfully!'); window.location.href='Dashboard.php';</script>";
            } else {
                echo "<div class='alert alert-danger'>Error deleting product: " . htmlspecialchars($stmt->error) . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Product not found!</div>";
        }

        $check_stmt->close();
    } else {
        echo "<script>alert('No product ID provided!'); window.location.href='Dashboard.php';</script>";
    }
} else {
    // Redirect to the Dashboard if accessed directly
    header("Location: Dashboard.php?message=Access denied!");
    exit;
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Dashboard.php">Inventory Admin Panel</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Delete Product</h2>
        <form method="GET" action="DeleteProduct.php">
            <div class="mb-3">
                <label for="product_id" class="form-label">Product ID</label>
                <input type="number" class="form-control" id="product_id" name="id" placeholder="Enter Product ID" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete Product</button>
        </form>
    </div>
</body>
</html>
