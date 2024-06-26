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
                <a href="index.php" class="products">Products</a>
                <a href="Category.php" class="category">Category</a>
                <a href="Supplier.php" class="supply">Supply</a>
                <a href="InStock.php" class="stock">Stock In</a>
            </nav>

<div class="container">
    <div class="dashboard-content">
        <h2>Admin Dashboard</h2>

        <!-- Display list of products -->
        <h3>Supplier List</h3><a href="add_stockIn.php" class="supplier">Add new</a>
        <table id="productTable">
            <thead>
                <tr>
                    <th width= "5%">ID</th>
                    <th width= "10%">Supplier Name</th>
                    <th width="10%">User Name</th>
                    <th width="10%">Stock in Date</th>
                    <th width="10%">Status  </th>
                    <th width= "5%">Total Amount</th>
                    <th width= "5%"></th>
                    <th width= "5%"></th>
                </tr>
            </thead>
            <tbody id="productTableBody"></tbody>
        </table>
    </div>
</div>

<script>
    window.onload = function() {
        fetchStockIn();
    };

    function fetchStockIn() {
    fetch('admFunctions.php?action=getAllStockIn')
        .then(response => {
            // Log the raw response for debugging
            console.log('Raw response:', response);
            return response.json();
        })
        .then(data => {
            updateTable(data);
        })
        .catch(error => {
            console.error('Error fetching supplier:', error);
        });
    }

    function updateTable(products) {
        var tableBody = document.getElementById('productTableBody');

        // Clear existing rows
        tableBody.innerHTML = '';

        // Add new rows with product data
        products.forEach(function(stock) {
            var row = tableBody.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);
        

            cell1.innerHTML = stock.StockId;
            cell2.innerHTML = stock.SupplierName;
            cell3.innerHTML = stock.FullName;
            cell4.innerHTML = stock.StockDate;
            cell5.innerHTML = stock.StockStatus;
            cell6.innerHTML = stock.TotalAmt;

             // Add update link
             var updateLink = document.createElement('a');
            updateLink.href = 'UI_updateStock.php?id=' + stock.StockId; // Update this line
            updateLink.textContent = 'Update';


            // Add delete link
            var deleteLink = document.createElement('a');
            deleteLink.href = '#'; // Replace with your delete script
            deleteLink.textContent = 'Delete';
            deleteLink.onclick = function() {
                // You can add a confirmation dialog or directly call a delete function here
                // For simplicity, this example uses a confirmation dialog
                var confirmDelete = confirm('Are you sure you want to delete this Record?');
                if (confirmDelete) {
                    deleteInstock(stock.StockId);
                }
                return false; // Prevent the default link behavior
            };

            cell7.appendChild(updateLink);
            cell8.appendChild(deleteLink);
        });
    }

    function deleteInstock(StockId) {
     // Perform the delete operation using AJAX
     fetch('admFunctions.php?action=deleteInStock&id=' + StockId)
        .then(response => response.json())
        .then(data => {
            
            // Check if the deletion was successful
            if (data.success) {
                // Reload the table after a successful delete
                fetchStockIn();
            } else {
                console.error('Error1 deleting Stock In:', data.error);
                fetchStockIn();
            }
        })
        .catch(error => {
            console.error('Error2 deleting Stock In:', error);
            fetchStockIn();
        });
}


</script>
</body>
</html>
