<?php
// Include the database connection file
include '../db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Check if a picture file is uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
        $base64Picture = base64_encode($pictureData);

        // SQL query to insert product data into the database
        $updateSql = "UPDATE Product SET ProductName = '$productName', ProductPrice = $price, ProductDescription = '$description', ProductImage = '$base64Picture'  WHERE ProductID = $productId";

        if ($con->query($updateSql)) {
            echo "Product updated successfully!";
            header('Refresh: 1; URL=index.php');
        } else {
            echo "Error updating product: " . $con->error;
        }
    } else {
        echo "Error uploading picture.";
    }
}

// Close the database connection
$con->close();
?>