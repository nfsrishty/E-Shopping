<?php
session_start(); // Start session to check if user is logged in

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

include "dbconnect.php"; // Include database connection

// Fetch products from the database
$sql = "SELECT id, name, category, price, stock FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Dashboard.php">Inventory Admin Panel</a>
            <div class="d-flex">
                <span class="navbar-text text-light">
                    Welcome, <?php echo $_SESSION['username']; ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light ml-2">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Product Dashboard</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['category']) . "</td>
                                <td>$" . htmlspecialchars(number_format($row['price'], 2)) . "</td>
                                <td>" . htmlspecialchars($row['stock']) . "</td>
                                <td>
                                    <a href='UpdateProduct.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Update</a>
                                    <a href='DeleteProduct.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
