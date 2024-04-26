<?php


include "../db.php"; // Include the database connection script

header('Content-Type: application/json');


//get all product
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
    echo json_encode(array('error' => 'Error executing the query: ' . $conn->error));
}

$con->close();
?>
