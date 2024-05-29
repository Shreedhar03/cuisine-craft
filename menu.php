<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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

// $menu = pg_query($PG_CONN, $fetchMenu);

// dummy data that comes in groupby category

$menu = [
    [
        'category' => 'Starters',
        'items' => [
            [
                'name' => 'Paneer Tikka',
                'price' => 200
            ],
            [
                'name' => 'Chicken Tikka',
                'price' => 250
            ]
        ]
    ],
    [
        'category' => 'Main Course',
        'items' => [
            [
                'name' => 'Paneer Butter Masala',
                'price' => 300
            ],
            [
                'name' => 'Chicken Butter Masala',
                'price' => 350
            ]
        ]
    ],
    [
        'category' => 'Desserts',
        'items' => [
            [
                'name' => 'Gulab Jamun',
                'price' => 100
            ],
            [
                'name' => 'Ras Malai',
                'price' => 150
            ]
        ]
    ]
];

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
                JW Marriott
            </h1>
            <p>
                123, XYZ Street, ABC City
            </p>
        </div>

        <div class="max-w-[1550px] mx-auto p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <?php foreach ($menu as $category) { ?>

                <div class="mt-8 bg-teal-100/70 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">
                        <?php echo $category['category']; ?>
                    </h2>

                    <!-- divider -->

                    <div class="w-16 h-[2px] bg-teal-900 mb-4 mt-1 rounded"></div>

                    <div class="">

                        <?php foreach ($category['items'] as $item) { ?>

                            <div class="flex items-end justify-between">
                                <h3 class="text-lg font-semibold">
                                    <?php echo $item['name']; ?>
                                </h3>
                                <p class="text-gray-900">
                                    Rs. <?php echo $item['price']; ?>
                                </p>
                            </div>

                        <?php } ?>

                    </div>
                </div>

            <?php } ?>

    </main>

    <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>