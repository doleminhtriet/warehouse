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

//Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'addProduct') {
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

//Update Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'updateProduct') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $description = $_POST['description'];

    // Check if a picture file is uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
        $base64Picture = base64_encode($pictureData);

        // SQL query to insert product data into the database
        $updateSql = "UPDATE Product SET ProductName = '$productName', ProductPrice = $price, 
        ProductQTY = $qty ,ProductDescription = '$description', ProductImage = '$base64Picture'  WHERE ProductID = $productId";

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

//Get All Product
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'deleteProduct') {

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

//Add Category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'addCategory') {
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];

    // Check if a picture file is uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pictureData = file_get_contents($_FILES['picture']['tmp_name']);
        $base64Picture = base64_encode($pictureData);

        // SQL query to insert category data into the database
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

//update Category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'updateCategory') {
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
            echo "Error updating category: " . $con->error;
        }
    } else {
        echo "Error uploading picture.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'deleteCategory') {
    if (isset($_GET['id'])) {
        $catID = $_GET['id'];

        // SQL query to delete the supplier
        $deleteSql = "DELETE FROM Category WHERE CatID = $catID";

        if ($con->query($deleteSql)) {
            // Supplier deleted successfully
            echo json_encode(array('success' => 'Category deleted successfully.'));
        } else {
            // Error deleting the supplier
            echo json_encode(array('error' => 'Error deleting the Category: ' . $con->error));
        }
    } else {
        // Supplier ID not provided in the query parameters
        echo json_encode(array('error' => 'Category ID not provided.'));
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
        header('Refresh: 1; URL=InStock.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

//Delete StockIN
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === 'deleteInStock') {
    if (isset($_GET['id'])) {
        $stockInId = $_GET['id'];

        // SQL query to delete the stockIn details first
        $sqlDeleteChild = "DELETE FROM StockInDetail WHERE StockInId = $stockInId";
        echo  $sqlDeleteChild;
        if ($con->query($sqlDeleteChild)) {
            // Now delete the main stockIn entry
            $deleteSql = "DELETE FROM StockIn WHERE StockId = $stockInId";
            if ($con->query($deleteSql)) {
                // StockIn deleted successfully
                echo json_encode(array('success' => 'StockIn deleted successfully.'));
            } else {
                // Error deleting the main stockIn
                echo json_encode(array('error' => 'Error deleting the main StockIn: ' . $con->error));
            }
        } else {
            // Error deleting the stockIn details
            echo json_encode(array('error' => 'Error deleting the stockIn details: ' . $con->error));
        }
    } else {
        // StockIn ID not provided in the query parameters
        echo json_encode(array('error' => 'StockIn ID not provided.'));
    }
}

// Close the database connection
$con->close();
