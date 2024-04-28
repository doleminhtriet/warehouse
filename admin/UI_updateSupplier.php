<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Supplier</title>
    <link rel="stylesheet" href="../css/adminStyle.css">
</head>

<body>

    <?php
    // Include your database connection file
    include '../db.php';

    // Check if the supplier ID is provided in the URL
    if (isset($_GET['id'])) {
        $supplierId = $_GET['id'];

        // Fetch supplier data based on the supplier ID
        $sql = "SELECT SupplierName, ContactName, Address, Phone FROM Supplier WHERE SupplierID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $supplierId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Adjust this based on your actual data structure
            $row = $result->fetch_assoc();
            $supplierName = $row['SupplierName'];
            $contact = $row['ContactName'];
            $address = $row['Address'];
            $phone = $row['Phone'];
    ?>

            <header>
                <h1>Update Supplier Info</h1>
            </header>

            <nav>
                <a href="index.php" class="categorys">Products</a>
                <a href="Category.php" class="category">Category</a>
                <a href="Supplier.php" class="supplier">Supplier</a>
            </nav>

            <div class="container">
                <form action="admFunctions.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="updateSupplier">
                    <input type="hidden" name="supplier_id" value="<?php echo $supplierId; ?>">
                    <label for="supplier_name">Supplier Name:</label>
                    <input type="text" name="supplier_name" required value="<?php echo htmlspecialchars($supplierName); ?>">
                    <label for="contact">Contact:</label>
                    <input type="text" name="contact" required value="<?php echo htmlspecialchars($contact); ?>">
                    <label for="address">Address:</label>
                    <input type="text" name="address" required value="<?php echo htmlspecialchars($address); ?>">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" required value="<?php echo htmlspecialchars($phone); ?>">
                   
                    <br><br>
                    <input type="submit" value="Update Supplier">
                </form>
            </div>

    <?php
        } else {
            // Supplier not found
            http_response_code(404);
        }
    } else {
        // Invalid request, supplier ID not provided
        http_response_code(400);
    }

    // Close the database connection
    $con->close();
    ?>

</body>

</html>
