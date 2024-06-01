<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <link rel="stylesheet" href="../global.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <!-- basic login/signup form in tailwind -->

    <!--  -->

    <div class="flex justify-center items-center h-screen bg-teal-100/50">
        <div class="bg-white p-16 rounded-lg shadow-lg flex flex-col items-center">
            <h2 class="text-4xl text-center font-bold mb-4 text-gray-800 logo">Cuisine Craft</h2>
            <p class="mb-8 text-xl">Create an account</p>
            <form action="../handlers/signup.php" method="POST" class="grid grid-cols-2 gap-2">
                <input type="text" autocomplete="FALSE" name="name" placeholder="Full Name" class="block border border-grey-light w-full p-3 rounded mb-4" required />
                <input type="email" autocomplete="FALSE" name="email" placeholder="Email" class="block border border-grey-light w-full p-3 rounded mb-4" required />
                <input type="text" autocomplete="FALSE" name="restaurant_name" placeholder="Restaurant Name" class="block border border-grey-light w-full p-3 rounded mb-4" required />
                <input type="text" autocomplete="FALSE" name="restaurant_address" placeholder="Restaurant Address" class="block border border-grey-light w-full p-3 rounded mb-4" required />
                <!-- <input type="text" autocomplete="FALSE" name="restaurant_location" placeholder="Restaurant Location (maps location)" class="block border border-grey-light w-full p-3 rounded mb-4" required /> -->
                <input type="password" autocomplete="FALSE" name="password" placeholder="Password" class="block border border-grey-light w-full p-3 rounded mb-4" required />
                <input type="password" autocomplete="FALSE" name="confirm_password" placeholder="Confirm Password" class="block border border-grey-light w-full p-3 rounded mb-4" required />
                <button type="reset" class="w-full text-center py-3 rounded text-teal-900 bg-teal-800/20 hover:bg-teal-800/30 focus:outline-none my-1">Clear</button>
                <button type="submit" class="w-full text-center py-3 rounded bg-teal-900 text-white hover:bg-teal-700 focus:outline-none my-1">Sign Up</button>
            </form>


            <?php

            session_start();

            // print error messages
            if (isset($_SESSION['error'])) {
                echo "<p class='text-red-500 text-center'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }

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
            } else {
                // echo "Opened database successfully\n";
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

            <p class="text-center mt-12">Already have an account? <a href="login.php" class="font-semibold text-blue-500 hover:text-blue-400">Login</a></p>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>