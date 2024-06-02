<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <link rel="stylesheet" href="../global.css">
    <!-- scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
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
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Fetch user details
    $user_query = "SELECT * FROM users WHERE id = $user_id";
    $user_result = pg_query($PG_CONN, $user_query);

    $user = pg_fetch_assoc($user_result);

    // Fetch restaurant details

    $restaurant_id = $user['restaurant_id'];
    // set restaurant_id in session
    $_SESSION['restaurant_id'] = $restaurant_id;

    $restaurant_query = "SELECT * FROM restaurants WHERE id = $restaurant_id";
    $restaurant_result = pg_query($PG_CONN, $restaurant_query);
    $restaurant = pg_fetch_assoc($restaurant_result);

    // Fetch categories
    $fetchMenu = "SELECT * FROM menu_items WHERE restaurant_id = $restaurant_id";
    $menu = pg_query($PG_CONN, $fetchMenu);

    $fetchCategories = "SELECT * FROM categories WHERE restaurant_id = $restaurant_id";
    $categories_result = pg_query($PG_CONN, $fetchCategories);
    // convert to assosciative array with id as key and name as value
    $categories = [];

    while ($category = pg_fetch_assoc($categories_result)) {
        $categories[$category['id']] = $category['name'];
    }

    // fetch menu items along with category name using join and group by category
    $fetchMenu = "SELECT menu_items.id, menu_items.name, menu_items.price, categories.name as category FROM menu_items JOIN categories ON menu_items.category_id = categories.id WHERE menu_items.restaurant_id = $restaurant_id GROUP BY menu_items.id, categories.name";
    $menu = pg_query($PG_CONN, $fetchMenu);

    // print the menu items category wise
    $menu_items = [];
    while ($item = pg_fetch_assoc($menu)) {
        $menu_items[$item['category']][] = $item;
    }

    ?>


    <main class="bg-teal-100/50">
        <div class="max-w-[1500px] mx-auto px-12 py-8 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold italic">
                    Welcome, <?php echo $user['name']; ?>
                </h2>
                <h1 class="text-4xl font-bold">
                    <?php echo $restaurant['name']; ?>
                    <!-- session res. id -->
                    <!-- <?php echo $_SESSION ?> -->
                </h1>
                <p>
                    <?php echo $restaurant['address']; ?>
                </p>
            </div>
            <button>
                <a href="../handlers/logout.php" class="text-white bg-red-500 px-4 py-[4px] rounded mt-4">Logout</a>
            </button>
        </div>
    </main>

    <!-- add menu item -->

    <form action="../handlers/add_item.php" class="max-w-[1500px] mx-auto px-12 py-8" method="POST">

        <!-- form to add a new items with a dropdown to select category -->

        <div class="mt-8">
            <h2 class="text-2xl font-bold">Add Item</h2>
            <div class="flex flex-wrap gap-3 mt-4 items-end">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Item Name</label>
                    <input type="text" name="name" placeholder="Biryani Full" class="block border border-grey-light w-64 p-3 rounded" required>
                </div>
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700">Item Price</label>
                    <input type="number" name="price" placeholder="199" class="block border border-grey-light w-32 p-3 rounded" required>
                </div>
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700">Category</label>
                    <select placeholder="Select category" name="category_id" class="block border border-grey-light w-36 p-3 rounded" required>
                        <?php
                        foreach ($categories as $id => $name) {
                            echo "<option value='$id'>$name</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="text-white bg-teal-900 px-4 py-[8px] rounded">Add</button>

            </div>
        </div>
    </form>

    <!-- add a category small button -->

    <?php
    if (isset($_SESSION['success']) || isset($_SESSION['error'])) {
    ?>
        <div class="mx-14 mt-2">
            <?php
            if (isset($_SESSION['success'])) {
                echo "<p class='text-green-500'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            } else {
                echo "<p class='text-red-500'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>
        </div>
    <?php
    }
    ?>
    <div id="category-box" class="h-[2rem] overflow-y-hidden transition-all">

        <button onclick="handleShowCategory()" class="mx-14 text-teal-700 font-semibold">Add a category +</button>

        <!-- form to add a new category -->

        <form action="../handlers/add_category.php" method="POST" id="categoryForm" class="flex mx-14 mt-2 gap-2">
            <input type="text" name="category_name" placeholder="Category Name" class="block border border-grey-light w-64 px-4 py-2 rounded" required />
            <button type="submit" class="text-white bg-teal-900 px-4 py-2 rounded focus:outline-none hover:bg-teal-700">Add</button>
        </form>
        <!-- show success or error message -->
    </div>

    <!-- menu -->

    <div class="max-w-[1550px] mx-auto px-14 py-8">
        <h2 class="text-2xl font-bold">Menu</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <?php foreach ($menu_items as $category => $items) { ?>
                <div class="mt-8 bg-teal-100/70 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold">
                        <?php echo htmlspecialchars($category); ?>
                    </h2>

                    <!-- divider -->
                    <div class="w-16 h-[2px] bg-teal-900 mb-4 mt-1 rounded"></div>

                    <div class="flex flex-col gap-1">
                        <?php foreach ($items as $item) { ?>
                            <div class="flex items-end justify-between">
                                <div class="flex gap-2">
                                    <?php if (isset($_SESSION['user_id'])) {
                                    ?>
                                        <button class="text-red-500 text-[3px] bg-red-100 rounded-full focus:outline-none hover:bg-red-200" onclick="handleDeleteItem(<?php echo $item['id']; ?>)">
                                            <img src="../assets/cross.svg" class="w-6 h-6" alt="delete" />
                                        </button>
                                    <?php
                                    }
                                    ?>

                                    <h3 class="text-lg font-semibold">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </h3>
                                </div>
                                <p class="text-gray-900 font-medium">
                                    <?php echo htmlspecialchars($item['price']); ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

    <script>
        function handleShowCategory() {
            const category_box = document.getElementById('category-box');

            category_box.classList.toggle('h-[2rem]');
            category_box.classList.toggle('h-[6rem]');
        }
    </script>


    <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>