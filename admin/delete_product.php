<?php
// Include the database connection file
include '../db.php';

// Check if the product ID is provided in the query parameters
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // SQL query to delete the product
    $deleteSql = "DELETE FROM Product WHERE ProductID = $productId";
    
    if ($con->query($deleteSql)) {
        // Product deleted successfully
        echo json_encode(array('success' => 'Product deleted successfully.'));
    } else {
        // Error deleting the product
        echo json_encode(array('error' => 'Error deleting the product: ' . $conn->error));
    }
} else {
    // Product ID not provided in the query parameters
    echo json_encode(array('error' => 'Product ID not provided.'));
}

// Close the database connection
$con->close();
?>