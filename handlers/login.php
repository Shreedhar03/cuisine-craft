<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

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

        // validate email and password
        $email_check_query = "SELECT * FROM Users WHERE email = '$email'";
        $email_check_result = pg_query($PG_CONN, $email_check_query);

        if (pg_num_rows($email_check_result) == 0) {
            $_SESSION['error'] = "Error: Email not found";
            pg_close($PG_CONN);
            header("Location: ../login.php");
            exit;
        }

        $user = pg_fetch_assoc($email_check_result);
        $hashed_password = $user['password'];

        if (!password_verify($password, $hashed_password)) {
            $_SESSION['error'] = "Error: Incorrect username or password";
            pg_close($PG_CONN);
            header("Location: ../login.php");
            exit;
        }

        $_SESSION['user'] = $user;

        // show the user name


        pg_close($PG_CONN);
        header("Location: ../login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: All fields are required";
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
