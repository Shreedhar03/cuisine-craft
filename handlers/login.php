<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // include database connection
        include '../config/db.php';

        // validate email and password
        $email_check_query = "SELECT * FROM Users WHERE email = '$email'";
        $email_check_result = pg_query($PG_CONN, $email_check_query);

        if (pg_num_rows($email_check_result) == 0) {
            $_SESSION['error'] = "Error: Email not found";
            pg_close($PG_CONN);
            header("Location: ../pages/login.php");
            exit;
        }

        $user = pg_fetch_assoc($email_check_result);
        $hashed_password = $user['password'];

        if (!password_verify($password, $hashed_password)) {
            $_SESSION['error'] = "Error: Incorrect username or password";
            pg_close($PG_CONN);
            header("Location: ../pages/login.php");
            exit;
        }

        // user verified
        // set user_id in session

        echo "User verified";

        $_SESSION['user_id'] = $user['id'];

        header("Location: ../pages/user.php");
        pg_close($PG_CONN);

        exit;
    } else {
        $_SESSION['error'] = "Error: All fields are required";
        header("Location: ../pages/login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Error: Invalid request method";
    header("Location: ../pages/login.php");
    exit;
}
