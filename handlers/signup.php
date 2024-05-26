<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {

        // print values

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $env = parse_ini_file('../.env');
        $PG_URL = $env['PG_URL'];
        $PG_OPTIONS = $env['PG_OPTIONS'];

        // Specify the endpoint ID in connection options
        $connection_string = $PG_URL . $PG_OPTIONS;

        // Establishing the connection
        $PG_CONN = pg_connect($connection_string);

        // Checking the connection
        if (!$PG_CONN) {
            // echo "Error : Unable to open database\n";
            exit;
        }

        // insert into the table
        $insertUser = "INSERT INTO Users (name, email, password) VALUES ('$name', '$email', '$password')";

        $userInserted = pg_query($PG_CONN, $insertUser);

        if (!$userInserted) {
            echo pg_last_error($PG_CONN);
        } else {
            echo "User created successfully\n";
        }

        // exit;
    } else {
        echo "Error: All fields are required";
    }
} else {
    echo "Error: Invalid request";
    exit;
}
