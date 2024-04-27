<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="css/adminStyle.css">

   
</head>
<body>

 

<?php
    // Include your database connection file
    include '../conn.php';

    // Check if the category ID is provided in the URL
    if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];

        // Fetch category data based on the category ID
        $sql = "SELECT category_name, description, category_image FROM category WHERE category_id = $categoryId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Adjust this based on your actual data structure
            $row = $result->fetch_assoc();
            $categoryName = $row['category_name'];
            $description = $row['description'];
            $img= $row['category_image'];


        
 
?>

        <header>
            <h1>Update Category Info</h1>
        </header>

        <nav>
                <a href="index.php" class="categorys">Products</a>
                <a href="Category.php" class="category">Category</a>
        </nav>
    
    <div class="container">
        <form action="updateCategory.php" method="post" enctype="multipart/form-data">
        
            <input type="hidden" id="category_id" name="category_id" value=<?php echo $categoryId; ?> >
            
            <label for="category_name">Product Name:</label>
            <input type="text" name="category_name" required value='<?php echo $row['category_name']; ?>'>

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
$conn->close();
?>


</body>
</html>
