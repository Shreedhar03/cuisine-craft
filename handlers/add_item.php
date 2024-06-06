<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['restaurant_id'] && isset($_POST["category_id"]) && isset($_POST["name"]) && isset($_POST["price"])) {

        // restaurant_id from session
        $restaurant_id = $_SESSION['restaurant_id'];
        $category_id = $_POST["category_id"];
        $name = $_POST["name"];
        $price = $_POST["price"];


        include '../config/db.php';

        // add category

        $add_item_query = "INSERT INTO menu_items (name, price, category_id, restaurant_id) VALUES ('$name', $price, $category_id, $restaurant_id)";
        $add_item_result = pg_query($PG_CONN, $add_item_query);

        if ($add_item_result) {
            $_SESSION['success'] = "Item added successfully";
            header("Location: ../pages/user.php");
            exit;
        } else {
            $_SESSION['error'] = "Error: Unable to add category";
            header("Location: ../pages/user.php");
            exit;
        }
    } else {
        exit;
    }
} else {
    $_SESSION['error'] = "Error: Invalid request method";
    header("Location: ../pages/login.php");
    exit;
}
