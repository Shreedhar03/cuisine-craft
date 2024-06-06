<?php
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Load the .env file and get the database connection details
include '../config/db.php';


// get id, name and price from form data
$id = $_POST['id'];
$name = $_POST['newName'];
$price = $_POST['newPrice'];
// edit the menu item from the database
$edit_query = "UPDATE menu_items SET name = $1, price = $2 WHERE id = $3";
$result = pg_query_params($PG_CONN, $edit_query, [$name, $price, $id]);

if ($result) {
    header("Location: ../pages/user.php");
    exit;
} else {
    $_SESSION['error'] = "Error: Unable to edit item";
}

// Close the database connection
pg_close($PG_CONN);
