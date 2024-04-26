<?php
// Include the database connection file
include '../db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];

    // Check if a picture file is uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
        $base64Picture = base64_encode($pictureData);

        // SQL query to insert product data into the database
        $insertSql = "INSERT INTO Category (CategoryName, CategoryDescription, CategoryImage) VALUES ('$categoryName', '$description', '$base64Picture')";

        if ($con->query($insertSql)) {
            echo "Category added successfully!";
            header('Refresh: 1; URL=Category.php');
        } else {
            echo "Error adding category: " . $con->error;
        }
    } else {
        echo "Error uploading picture.";
    }
}
// Close the database connection
$con->close();
?>