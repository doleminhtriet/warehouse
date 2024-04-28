<?php

include "db.php";

// Function to get product quantity by ID
function getProductByID($productId, $con) {
    echo "Product ID: " . $productId;
    $query = "SELECT * FROM Product WHERE ProductID = '$productId'";
    echo "SQL Query: " . $query;
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stockQty = intval($row['quantity']);
        return $stockQty;
    } else {
        $error = "Error: " . mysqli_error($con);
        echo $error;
        return $error;
    }
}
?>