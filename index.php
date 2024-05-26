<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <!-- tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="global.css">
</head>

<body>

    <!-- basic login/signup form in tailwind -->

    <!--  -->

    <div class="flex justify-center items-center h-screen bg-gray-200">
        <div class="bg-white p-16 rounded-lg shadow-lg flex flex-col items-center">
            <h2 class="text-4xl text-center font-bold mb-4 text-gray-800 logo">Cuisine Craft</h2>
            <p class="mb-8 text-xl">Create an account</p>
            <form action="handlers/signup.php" method="POST" class="w-72">
                <input type="text" autocomplete="FALSE" name="name" placeholder="Full Name" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <input type="email" autocomplete="FALSE" name="email" placeholder="Email" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <input type="password" autocomplete="FALSE" name="password" placeholder="Password" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <input type="password" autocomplete="FALSE" name="confirm_password" placeholder="Confirm Password" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <button type="submit" class="w-full text-center py-3 rounded bg-green-500 text-white hover:bg-green-400 focus:outline-none my-1">Sign Up</button>
            </form>
            <p class="text-center mt-12">Already have an account? <a href="login.php" class="font-semibold text-blue-500 hover:text-blue-400">Login</a></p>
        </div>

        <?php

        $env = parse_ini_file('.env');
        $PG_URL = $env['PG_URL'];
        $PG_OPTIONS = $env['PG_OPTIONS'];

        // Specify the endpoint ID in connection options
        $connection_string = $PG_URL . $PG_OPTIONS;

        // Establishing the connection
        $PG_CONN = pg_connect($connection_string);

        // Checking the connection
        if (!$PG_CONN) {
            // echo "Error : Unable to open database\n";
        } else {
            // echo "Opened database successfully!!\n";
        }
        // Create a table
        $createUsersTable = "CREATE TABLE IF NOT EXISTS Users ( 
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

        $usersTableCreated = pg_query($PG_CONN, $createUsersTable);

        if (!$usersTableCreated) {
            echo pg_last_error($PG_CONN);
        } else {
            // echo "Table created successfully\n";
        }


        ?>


</body>

</html>