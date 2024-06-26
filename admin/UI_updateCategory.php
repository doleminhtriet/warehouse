<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="../css/adminStyle.css">

   
</head>
<body>

 

<?php
    // Include your database connection file
    include '../db.php';

    // Check if the category ID is provided in the URL
    if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];

        // Fetch category data based on the category ID
        $sql = "SELECT CategoryName, CategoryDescription, CategoryImage FROM Category WHERE CatID = $categoryId";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Adjust this based on your actual data structure
            $row = $result->fetch_assoc();
            $categoryName = $row['CategoryName'];
            $description = $row['CategoryDescription'];
            $img= $row['CategoryImage'];


        
 
?>

        <header>
            <h1>Update Category Info</h1>
        </header>

        <nav>
                <a href="index.php" class="categorys">Products</a>
                <a href="Category.php" class="category">Category</a>
        </nav>
    
    <div class="container">
        <form action="admFunctions.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="action" value="updateCategory">
        
            <input type="hidden" id="category_id" name="category_id" value=<?php echo $categoryId; ?> >
            
            <label for="category_name">Product Name:</label>
            <input type="text" name="category_name" required value='<?php echo $row['CategoryName']; ?>'>

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo $description; ?></textarea>
            <?php if (!empty($img)): ?>

            <img src="data:image/jpeg;base64,<?php echo ($img); ?>" alt="Product Image" style="max-width:100px; max-height:100px;>

            <?php endif; ?>
            <label for="picture"></label>
            <label for="picture">Picture:</label>
            <input type="file" name="picture" accept="image/*" required>

            
            <br><br>
            <input type="submit" value="Update Category">

        </form>
   
    </div>





<?php
        
     

       
    } else {
        // Product not found
        http_response_code(404);
    }
} else {
    // Invalid request, category ID not provided
    http_response_code(400);
}

// Close the database connection
$con->close();
?>


</body>
</html>
