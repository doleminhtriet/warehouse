<?php
// Include the database connection file
include '../db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'];

    // Check if a picture file is uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
        $base64Picture = base64_encode($pictureData);

        // SQL query to insert product data into the database
        $insertSql = "INSERT INTO Product (ProductName, ProductPrice, CatID, ProductDescription, ProductQTY, ProductImage) 
        VALUES ('$productName', $price, '$categoryId', '$description',$qty, '$base64Picture')";
        //echo $insertSql; 

        if ($con->query($insertSql)) {
            echo "Product added successfully!";
            header('Refresh: 1; URL=index.php');
        } else {
            echo "Error adding product: " . $con->error;
        }
    } else {
        echo "Error uploading picture.";
    }
}

// Close the database connection
$con->close();
?>