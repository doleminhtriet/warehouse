<?php
session_start();
include "admFunctions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock-In Form</title>
    <link rel="stylesheet" href="../css/adminStyle.css">

    <style>
        /* Additional CSS styles can be added here */
        /* Style for form labels */
        label {
            display: block;
            margin-bottom: 5px;
        }

        /* Style for form inputs */
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Style for file input */
        input[type="file"] {
            margin-top: 5px;
        }

        /* Style for submit button */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Style for submit button on hover */
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Style for data grid view */
        #stockInDetail {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        #stockInDetail th,
        #stockInDetail td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #stockInDetail th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <header>
        <h1>Stock-In Form</h1>
    </header>

    <nav>
        <a href="index.php" class="products">Products</a>
        <a href="Category.php" class="category">Category</a>
        <a href="Supplier.php" class="supply">Supply</a>
        <a href="InStock.php" class="stock">Stock In</a>

    </nav>
    <div id="top-header">
        <div class="container">

            <ul class="header-links pull-right">

                <li>
                    <?php
                    include "../db.php";
                    if (isset($_SESSION["uid"])) {
                        $sql = "SELECT FullName FROM CustomerInfo WHERE UserId='$_SESSION[uid]'";
                        $query = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($query);
                        echo '
                               <div class="dropdownn">
                                  <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><i class="fa fa-user-o"></i> Hi ' . $row["FullName"] . '</a>
                                  <div class="dropdownn-content">
                                    <a href="" data-toggle="modal" data-target="#profile"><i class="fa fa-user-circle" aria-hidden="true" ></i>My Profile</a>
                                    <a href="../logout.php"  ><i class="fa fa-sign-in" aria-hidden="true"></i>Log out</a>
                                    
                                  </div>
                                </div>';
                    } else {
                        echo '
                                <div class="dropdownn">
                                  <a href="#" class="dropdownn" data-toggle="modal" data-target="#myModal" ><i class="fa fa-user-o"></i> My Account</a>
                                  <div class="dropdownn-content">
                                    <a href="" data-toggle="modal" data-target="#Modal_login"><i class="fa fa-sign-in" aria-hidden="true" ></i>Login</a>
                                    <a href="" data-toggle="modal" data-target="#Modal_register"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a>
                                    
                                  </div>
                                </div>';
                    }
                    ?>

                </li>




            </ul>

        </div>
    </div>
    <div class="container">
        <form action="admFunctions.php" method="post">

            <input type="hidden" name="action" value="addStockIn">

            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID" required value='<?php echo $_SESSION["uid"]; ?>' readonly>
            <input type="text" id="UserName" name="UserName" required value='<?php echo $row["FullName"]  ?>' readonly>

            <label for="supplierSelect">Select Supplier:</label>
            <select id="supplierSelect" name="supplierID"></select>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="note">Note:</label>
            <textarea id="note" name="note" required></textarea>

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="sent">Sent</option>
                <option value="received">Received</option>
            </select>

            <h3>Stock-In Detail</h3>
            <table id="stockInDetail">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><select name="productID[]" required></select></td>
                        <td><input type="number" name="quantity[]" required onchange="calculateTotal(this)"></td>
                        <td><input type="number" name="price[]" required onchange="calculateTotal(this)"></td>
                        <td><input type="text" name="total[]" readonly></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" onclick="addRow()">Add Row</button><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        function addRow() {
            var table = document.getElementById("stockInDetail").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            cell1.innerHTML = '<select name="productID[]" required></select>';
            cell2.innerHTML = '<input type="number" name="quantity[]" required onchange="calculateTotal(this)">';
            cell3.innerHTML = '<input type="number" name="price[]" required onchange="calculateTotal(this)">';
            cell4.innerHTML = '<input type="text" name="total[]" readonly>';

            // Populate the newly added combobox with product data
            var productSelect = cell1.querySelector('select');
            fetchAndPopulateProducts();
        }

        function calculateTotal(input) {
            var row = input.parentNode.parentNode;
            var quantity = parseFloat(row.cells[1].getElementsByTagName('input')[0].value);
            var price = parseFloat(row.cells[2].getElementsByTagName('input')[0].value);
            var total = quantity * price;
            row.cells[3].getElementsByTagName('input')[0].value = total.toFixed(2);
        }
    </script>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchAndPopulateSuppliers();
        fetchAndPopulateProducts();
    });



    function fetchAndPopulateSuppliers() {
        fetch('admFunctions.php?action=getAllSupplier')
            .then(response => response.json())
            .then(suppliers => {
                const supplierSelect = document.getElementById('supplierSelect');

                suppliers.forEach(supplier => {
                    const option = document.createElement('option');
                    option.value = supplier.SupplierID;
                    option.textContent = supplier.SupplierName;
                    supplierSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching Suppliers:', error));
    }

    function fetchAndPopulateProducts() {
        fetch('admFunctions.php?action=getAllProduct')
            .then(response => response.json())
            .then(products => {
                const productSelects = document.querySelectorAll('select[name="productID[]"]');

                productSelects.forEach(select => {
                    products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.ProductID;
                        option.textContent = product.ProductName;
                        select.appendChild(option);
                    });
                });
            })
            .catch(error => console.error('Error fetching Products:', error));
    }
</script>

</html>