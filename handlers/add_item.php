<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['restaurant_id'] && isset($_POST["category_id"]) && isset($_POST["name"]) && isset($_POST["price"])) {

        // restaurant_id from session
        $restaurant_id = $_SESSION['restaurant_id'];
        $category_id = $_POST["category_id"];
        $name = $_POST["name"];
        $price = $_POST["price"];


        $env = parse_ini_file('../.env');
        $PG_URL = $env['PG_URL'];
        $PG_OPTIONS = $env['PG_OPTIONS'];

        $connection_string = $PG_URL . $PG_OPTIONS;
        $PG_CONN = pg_connect($connection_string);

        // Checking the connection
        if (!$PG_CONN) {
            $_SESSION['error'] = "Error: Unable to open database";
            // echo "Error : Unable to open database\n";
        } else {
            // echo "Opened database successfully\n";
        }

        // add category

        $add_item_query = "INSERT INTO menu_items (name, price, category_id, restaurant_id) VALUES ('$name', $price, $category_id, $restaurant_id)";
        $add_item_result = pg_query($PG_CONN, $add_item_query);

        if ($add_item_result) {
            $_SESSION['success'] = "Item added successfully";
            header("Location: ../user.php");
            exit;
        } else {
            $_SESSION['error'] = "Error: Unable to add category";
            header("Location: ../user.php");
            exit;
        }
    } else {
        exit;
    }
} else {
    $_SESSION['error'] = "Error: Invalid request method";
    header("Location: ../login.php");
    exit;
}
