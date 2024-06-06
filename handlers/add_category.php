<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['restaurant_id'] && isset($_POST["category_name"])) {
        echo "inside isset";
        echo "restaurant_id: $restaurant_id, category_name: $category_name";
        // restaurant_id from session
        $restaurant_id = $_SESSION['restaurant_id'];
        $category_name = $_POST["category_name"];


        include '../config/db.php';

        // add category

        $add_category_query = "INSERT INTO categories (name, restaurant_id) VALUES ('$category_name', $restaurant_id)";
        $add_category_result = pg_query($PG_CONN, $add_category_query);

        if ($add_category_result) {
            $_SESSION['success'] = "Category added successfully";
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
