<?php
session_start();
header('Content-Type: application/json');

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
    http_response_code(500); // Internal Server Error
    $_SESSION['error'] = "Error: Unable to open database";
    echo json_encode(['success' => false, 'error' => 'Unable to open database']);
    exit;
}

// Get the item ID from the request body
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!isset($id) || !is_int($id)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Invalid or missing item ID']);
    exit;
}

// Delete the menu item from the database
$delete_query = "DELETE FROM menu_items WHERE id = $1";
$result = pg_query_params($PG_CONN, $delete_query, [$id]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500); // Internal Server Error
    $_SESSION['error'] = "Error: Unable to delete item";
    echo json_encode(['success' => false, 'error' => pg_last_error($PG_CONN)]);
}

// Close the database connection
pg_close($PG_CONN);
