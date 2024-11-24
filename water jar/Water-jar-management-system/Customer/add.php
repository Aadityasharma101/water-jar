<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sample');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customer_name'];
    $quantity = (int)$_POST['water_quantity']; // Ensure this is an integer
    $price = (float)$_POST['price']; // Ensure this is a float
    $date = $_POST['delivery_date'];

    // Insert query
    $stmt = $conn->prepare("INSERT INTO water_records (customer_name, water_quantity, price, delivery_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sids', $name, $quantity, $price, $date); // 's' for string, 'i' for integer, 'd' for decimal, 's' for string (date)

    if ($stmt->execute()) {
        echo "<script>alert('Record added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Record</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="mb-3">
                <label for="water_quantity" class="form-label">Water Quantity (in liters)</label>
                <input type="number" class="form-control" id="water_quantity" name="water_quantity" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="delivery_date" class="form-label">Delivery Date</label>
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Record</button>
        </form>
    </div>
</body>
</html>
