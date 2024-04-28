<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminStyle.css">
</head>
<body>

<header>
                <h1>Admin Dashboard</h1>
            </header>
    
            <nav>
                <a href="#" class="products">Products</a>
                <a href="Category.php" class="category">Category</a>
                <a href="Supplier.php" class="supply">Supply</a>
                <a href="add_stockIn.php" class="stock">Supply</a>
            </nav>

<div class="container">
    <div class="dashboard-content">
        <h2>Welcome to the Admin Dashboard</h2>

        <!-- Display list of products -->
        <h3>Product List</h3><a href="add_product.html" class="products">Add new</a>
        <table id="productTable">
            <thead>
                <tr>
                    <th width= "5%">ID</th>
                    <th width= "10%">Name</th>
                    <th width= "10%">Price</th>
                    <th width= "10%">QTY</th>
                    <th width="30%">Description</th>
                    <th>Img</th>
                    <th width= "5%"></th>
                    <th width= "5%"></th>
                </tr>
            </thead>
            <tbody id="productTableBody"></tbody>
        </table>
    </div>
</div>

    <script>
        //initial load page
        window.onload = function() {
            fetchProducts();
        };

        //load product from database
        function fetchProducts() {
        fetch('get_products.php')
            .then(response => {
                // Log the raw response for debugging
                console.log('Raw response:', response);
                return response.json();
            })
            .then(data => {
                updateTable(data);
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
        }

        //load product into table
        function updateTable(products) {
            var tableBody = document.getElementById('productTableBody');

            // Clear existing rows
            tableBody.innerHTML = '';

            // Add new rows with product data
            products.forEach(function(product) {
                var row = tableBody.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);

                cell1.innerHTML = product.ProductID;
                cell2.innerHTML = product.ProductName;
                cell3.innerHTML = '$'+product.ProductPrice;
                cell4.innerHTML = product.ProductQTY;
                cell5.innerHTML = product.ProductDescription;
                cell6.innerHTML = '<img src="data:image/jpeg;base64,' + product.ProductImage + '" alt="Product Image" style="max-width:100px; max-height:100px;">';

                // Add update link
                var updateLink = document.createElement('a');
                updateLink.href = 'UI_updateProduct.php?id=' + product.ProductID; // Update this line
                updateLink.textContent = 'Update';


                // Add delete link
                var deleteLink = document.createElement('a');
                deleteLink.href = 'delete_product.php?id=' + product.ProductID; // Replace with your delete script
                deleteLink.textContent = 'Delete';
                deleteLink.onclick = function() {
                    // You can add a confirmation dialog or directly call a delete function here
                    // For simplicity, this example uses a confirmation dialog
                    var confirmDelete = confirm('Are you sure you want to delete this product?');
                    if (confirmDelete) {
                        deleteProduct(product.ProductID);
                    }
                    return false; // Prevent the default link behavior
                };

                var slash = document.createTextNode(' / ');
                cell7.appendChild(updateLink);
                cell7.appendChild(slash);
                cell7.appendChild(deleteLink);
            });
        }

        //delete product, call function  delete_product.php
        function deleteProduct(productId) {
        // Perform the delete operation using AJAX
        fetch('delete_product.php?id=' + productId)
            .then(response => response.json())
            .then(data => {
                // Check if the deletion was successful
                if (data.success) {
                    // Reload the table after a successful delete
                    fetchProducts();
                } else {
                    console.error('Error deleting product:', data.error);
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
            });
    }


    </script>
</body>
</html>
