<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $restaurant_name = $_POST["restaurant_name"];
        $restaurant_address = $_POST["restaurant_address"];

        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Error: Passwords do not match";
            header("Location: ../pages/signup.php");
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        include '../config/db.php';

        // Check if the email already exists
        $email_check_query = "SELECT * FROM Users WHERE email = '$email'";
        $email_check_result = pg_query($PG_CONN, $email_check_query);

        if (pg_num_rows($email_check_result) > 0) {
            $_SESSION['error'] = "Error: Email is already in use";
            pg_close($PG_CONN);
            header("Location: ../pages/signup.php");
            exit;
        }

        // Create restaurant
        $insert_restaurant_query = "INSERT INTO restaurants (name, address) VALUES ('$restaurant_name', '$restaurant_address')";
        $restaurant_result = pg_query($PG_CONN, $insert_restaurant_query);

        if ($restaurant_result) {
            // Restaurant created successfully
            $insert_query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            $result = pg_query($PG_CONN, $insert_query);

            if (!$result) {
                $_SESSION['error'] = error_get_last()['message'];
                pg_close($PG_CONN);
                header("Location: ../pages/signup.php");
                exit;
            }
        } else {
            // Restaurant creation failed
            $_SESSION['error'] = error_get_last()['message'];
            pg_close($PG_CONN);
            header("Location: ../pages/signup.php");
            exit;
        }


        pg_close($PG_CONN);
        header("Location: ../pages/login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: All fields are required";
        header("Location: ../pages/signup.php");
        exit;
    }
} else {
    header("Location: ../pages/signup.php");
    exit;
}
