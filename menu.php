<?php

session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

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

// Fetch restaurant details

$restaurant_query = "SELECT * FROM restaurants WHERE id = $restaurantId";
$restaurant_result = pg_query($PG_CONN, $restaurant_query);
$restaurant = pg_fetch_assoc($restaurant_result);


// fetch menu items along with category name using join and group by category
$fetchMenu = "SELECT menu_items.id, menu_items.name, menu_items.price, categories.name as category FROM menu_items JOIN categories ON menu_items.category_id = categories.id WHERE menu_items.restaurant_id = $restaurantId GROUP BY menu_items.id, categories.name";
$menu = pg_query($PG_CONN, $fetchMenu);

// print the menu items category wise
$menu_items = [];
while ($item = pg_fetch_assoc($menu)) {
    $menu_items[$item['category']][] = $item;
}


if (!$menu) {
    echo pg_last_error($PG_CONN);
} else {
    // echo "Menu fetched successfully\n";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>CC | Restaurant </title>
    <link rel="stylesheet" href="global.css">
    <!-- scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <main>

        <div class="bg-teal-100/50 p-8">

            <a href="index.php">
                <span class="text-2xl font-bold">
                    &larr;&nbsp;
                </span>
                Back
            </a>

            <h1 class="text-3xl font-bold mt-3">
                <?php echo htmlspecialchars($restaurant['name']); ?>

            </h1>
            <p>
                <?php echo htmlspecialchars($restaurant['address']); ?>
            </p>
        </div>

        <div class="max-w-[1550px] mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <?php foreach ($menu_items as $category => $items) { ?>
                <div class="mt-8 bg-teal-100/70 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">
                        <?php echo htmlspecialchars($category); ?>
                    </h2>

                    <!-- divider -->
                    <div class="w-16 h-[2px] bg-teal-900 mb-4 mt-1 rounded"></div>

                    <div class="">
                        <?php foreach ($items as $item) { ?>
                            <div class="flex items-end justify-between">
                                <h3 class="text-lg font-semibold">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </h3>
                                <p class="text-gray-900">
                                    Rs. <?php echo htmlspecialchars($item['price']); ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

    </main>

    <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>