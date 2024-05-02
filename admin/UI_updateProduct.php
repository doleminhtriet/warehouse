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

    // Check if the product ID is provided in the URL
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Fetch product data based on the product ID
        $sql = "SELECT ProductName, ProductPrice, ProductQTY, ProductDescription, ProductImage FROM Product WHERE ProductID = $productId";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Adjust this based on your actual data structure
            $row = $result->fetch_assoc();
            $productName = $row['ProductName'];
            $price = $row['ProductPrice'];
            $qty = $row['ProductQTY'];
            $description = $row['ProductDescription'];
            $img= $row['ProductImage'];
            //echo $row['product_name'];


        
 
?>

        <header>
            <h1>Update Product Info</h1>
        </header>

        <nav>
        <a href="index.php" class="products">Products</a>
        <a href="Category.php" class="category">Category</a>
        <a href="Supplier.php" class="supply">Supply</a>
        <a href="add_stockIn.php" class="stock">Stock In</a>
        </nav>
    
    <div class="container">
        <form action="admFunctions.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="action" value="updateProduct">
        
            <input type="hidden" id="product_id" name="product_id" value=<?php echo $productId; ?> >
            
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required value='<?php echo $row['ProductName']; ?>'>

            <label for="price">Price:</label>
            <input type="number" name="price" required step="0.01" value=<?php echo $price; ?> > 

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required value=<?php echo $qty; ?> > 

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo $description; ?></textarea>
            <?php if (!empty($img)): ?>

            <img src="data:image/jpeg;base64,<?php echo ($img); ?>" alt="Product Image" style="max-width:100px; max-height:100px;>

            <?php endif; ?>
            <label for="picture"></label>
            <label for="picture">Picture:</label>
            <input type="file" name="picture" accept="image/*" required>

            
            <br><br>
            <input type="submit" value="Update Product">

        </form>
   
    </div>





<?php
        
     

       
    } else {
        // Product not found
        http_response_code(404);
    }
} else {
    // Invalid request, product ID not provided
    http_response_code(400);
}

// Close the database connection
$con->close();
?>


</body>
</html>
