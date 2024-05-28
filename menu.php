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
    // echo "Opened database successfully\n";
}

// fetch menu by restaurant id

$restaurantId = $_GET['id'];

$fetchMenu = "SELECT * FROM menu_items WHERE restaurant_id = $restaurantId";

$menu = pg_query($PG_CONN, $fetchMenu);

if (!$menu) {
    echo pg_last_error($PG_CONN);
} else {
    // echo "Menu fetched successfully\n";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Menu Details</title>
</head>

<body>


    <h1>Menu</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <?php while ($row = pg_fetch_assoc($menu)) : ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2"><?= $row['name'] ?></h3>
                <p class="text-gray-600 mb-4"><?= $row['price'] ?></p>
            </div>
        <?php endwhile; ?>

    </div>

</body>

</html>