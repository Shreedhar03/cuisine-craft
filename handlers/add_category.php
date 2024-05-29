<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['restaurant_id'] && isset($_POST["category_name"])) {
        echo "inside isset";
        echo "restaurant_id: $restaurant_id, category_name: $category_name";
        // restaurant_id from session
        $restaurant_id = $_SESSION['restaurant_id'];
        $category_name = $_POST["category_name"];


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

        $add_category_query = "INSERT INTO categories (name, restaurant_id) VALUES ('$category_name', $restaurant_id)";
        $add_category_result = pg_query($PG_CONN, $add_category_query);

        if ($add_category_result) {
            $_SESSION['success'] = "Category added successfully";
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
