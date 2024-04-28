<?php
// Include the database connection file
include '../conn.php';

// Check if the category ID is provided in the query parameters
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // SQL query to delete the category
    $deleteSql = "DELETE FROM Category WHERE CatID = $categoryId";
    
    if ($conn->query($deleteSql)) {
        // category deleted successfully
        echo json_encode(array('success' => 'Category deleted successfully.'));
    } else {
        // Error deleting the category
        echo json_encode(array('error' => 'Error deleting the category: ' . $conn->error));
    }
} else {
    // category ID not provided in the query parameters
    echo json_encode(array('error' => 'category ID not provided.'));
}

// Close the database connection
$conn->close();
?>