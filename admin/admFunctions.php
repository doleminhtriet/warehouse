<?php

include "../db.php"; // Include the database connection script



// Check if the request is an AJAX request and if it contains the specified action
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'getAllSupplier') {

    header('Content-Type: application/json');

    // Fetch data from the database
    $query = "SELECT * FROM Supplier";
    $result = mysqli_query($con, $query);

    if ($result) {
        // Fetch and encode the results as JSON
        $suppliers = array();
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        echo json_encode($suppliers);
    } else {
        echo json_encode(array('error' => 'Error executing the query: ' . $con->error));
    }
}


//Get All Category
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'getAllCategory') {

    $sql = "SELECT * FROM Category";
    $result = $con->query($sql);

    // Check if there are results
    if ($result) {
        // Fetch and encode the results as JSON
        $category = array();
        while ($row = $result->fetch_assoc()) {
            $category[] = $row;
        }
        echo json_encode($category);
    } else {
        echo json_encode(array('error' => 'Error executing the query: ' . $con->error));
    }
}

//Get All Product
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'getAllProduct') {

    $sql = "SELECT * FROM Product";
    $result = $con->query($sql);

    // Check if there are results
    if ($result) {
        // Fetch and encode the results as JSON
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
    } else {
        echo json_encode(array('error' => 'Error executing the query: ' . $con->error));
    }
}


//Get All StockIn   
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'getAllStockIn') {

    $sql = "SELECT * FROM V_StockInAll";
    $result = $con->query($sql);

    // Check if there are results
    if ($result) {
        // Fetch and encode the results as JSON
        $stocks = array();
        while ($row = $result->fetch_assoc()) {
            $stocks[] = $row;
        }
        echo json_encode($stocks);
    } else {
        echo json_encode(array('error' => 'stocks Error executing the query: ' . $con->error));
    }
}



// Handle listSupplier action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'addSupplier') {
    $supplierName = $_POST['supplier_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // SQL query to insert product data into the database
    $insertSql = "INSERT INTO Supplier (SupplierName, ContactName, Address, Phone)
     VALUES ('$supplierName', '$contact', '$address', '$phone')";

    if ($con->query($insertSql)) {
        echo "Supplier added successfully!";
        header('Refresh: 1; URL=Supplier.php');
    } else {
        echo "Error adding Supplier: " . $con->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'deleteSupplier') {
    if (isset($_GET['id'])) {
        $supplierId = $_GET['id'];

        // SQL query to delete the supplier
        $deleteSql = "DELETE FROM Supplier WHERE SupplierID = $supplierId";

        if ($con->query($deleteSql)) {
            // Supplier deleted successfully
            echo json_encode(array('success' => 'Supplier deleted successfully.'));
        } else {
            // Error deleting the supplier
            echo json_encode(array('error' => 'Error deleting the supplier: ' . $con->error));
        }
    } else {
        // Supplier ID not provided in the query parameters
        echo json_encode(array('error' => 'Supplier ID not provided.'));
    }
}

// Handle listSupplier action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'updateSupplier') {
    $supplierId = $_POST['supplier_id'];
    $supplierName = $_POST['supplier_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // SQL query to insert category data into the database
    $updateSql = "UPDATE Supplier SET SupplierName = '$supplierName', ContactName = '$contact', 
    Address = '$address', Phone='$phone' WHERE SupplierID = $supplierId";

    if ($con->query($updateSql)) {
        echo "Supplier updated successfully!";
        header('Refresh: 1; URL=Supplier.php');
    } else {
        echo "Error updating Supplier: " . $con->error;
    }
}

// Handle StockIn form add new
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'addStockIn') {
    // Process the parent form data
    $userID = $_POST['userID'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $status = $_POST['status'];
    $orderID = $_POST['orderID'];
    $supplierID = $_POST['supplierID'];

    $sql = "INSERT INTO StockIn (UserID, StockDate, StockNote, StockStatus, SupplierID)
        VALUES ('$userID', '$date', '$note', '$status', '$supplierID')";

    if (mysqli_query($con, $sql)) {
        $stock_in_id = mysqli_insert_id($con);

        // Process the child form data (stock-in detail)
        $productIDs = $_POST['productID'];
        $quantities = $_POST['quantity'];
        $prices = $_POST['price'];
        $totals = $_POST['total']; // Assuming you're also submitting the total from the form

        foreach ($productIDs as $key => $productID) {
            $quantity = $quantities[$key];
            $price = $prices[$key];
            $total = $totals[$key]; // Get total from submitted data

            $sql = "INSERT INTO StockInDetail (StockInId, ProductID, Quantity, Price, Total)
                VALUES ($stock_in_id, '$productID', $quantity, $price, $total)";
            mysqli_query($con, $sql);
        }

        echo "Stock-in data saved successfully!";
        header('Refresh: 1; URL=Supplier.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Close the database connection
$con->close();
