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
            header("Location: ../signup.php");
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $env = parse_ini_file('../.env');
        $PG_URL = $env['PG_URL'];
        $PG_OPTIONS = $env['PG_OPTIONS'];

        $connection_string = $PG_URL . $PG_OPTIONS;
        $PG_CONN = pg_connect($connection_string);

        // Checking the connection
        if (!$PG_CONN) {
            // echo "Error : Unable to open database\n";
        } else {
            // echo "Opened database successfully\n";
        }

        // Check if the email already exists
        $email_check_query = "SELECT * FROM Users WHERE email = '$email'";
        $email_check_result = pg_query($PG_CONN, $email_check_query);

        if (pg_num_rows($email_check_result) > 0) {
            $_SESSION['error'] = "Error: Email is already in use";
            pg_close($PG_CONN);
            header("Location: ../signup.php");
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
                header("Location: ../signup.php");
                exit;
            }
        } else {
            // Restaurant creation failed
            $_SESSION['error'] = error_get_last()['message'];
            pg_close($PG_CONN);
            header("Location: ../signup.php");
            exit;
        }


        pg_close($PG_CONN);
        header("Location: ../login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: All fields are required";
        header("Location: ../signup.php");
        exit;
    }
} else {
    header("Location: ../signup.php");
    exit;
}
