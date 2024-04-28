<?php
// Include the database connection file
include '../db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    
    $categoryId = $_POST['category_id'];
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];

    // Check if a picture file is uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
        $base64Picture = base64_encode($pictureData);

        // SQL query to insert category data into the database
        $updateSql = "UPDATE Category SET CategoryName = '$categoryName', CategoryDescription = '$description', 
        CategoryImage = '$base64Picture' WHERE CatID = $categoryId";

        if ($con->query($updateSql)) {
            echo "Category updated successfully!";
            header('Refresh: 1; URL=Category.php');
        } else {
            echo "Error updating category: " . $conn->error;
        }
    } else {
        echo "Error uploading picture.";
    }
}

// Close the database connection
$con->close();
?>