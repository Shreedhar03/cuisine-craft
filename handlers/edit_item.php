<?php
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Load the .env file and get the database connection details
$env = parse_ini_file('../.env');
$PG_URL = $env['PG_URL'];
$PG_OPTIONS = $env['PG_OPTIONS'];
$connection_string = $PG_URL . $PG_OPTIONS;
$PG_CONN = pg_connect($connection_string);

if (!$PG_CONN) {
    echo "alert('Error: Unable to open database')";
    http_response_code(500); // Internal Server Error
    $_SESSION['error'] = "Error: Unable to open database";
    echo json_encode(['success' => false, 'error' => 'Unable to open database']);
    exit;
}


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
