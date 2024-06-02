<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <link rel="stylesheet" href="../global.css">
    <!-- scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <main class="bg-teal-900 h-[60vh] flex flex-col justify-center">

        <div class="flex flex-col items-center gap-3">
            <h1 class="logo text-white text-5xl text-center">CuisineCraft</h1>

            <h3 class="font-bold text-3xl text-white text-center">
                Effortless. Modern. Intuitive.
            </h3>

            <p class="text-xl text-white text-center mb-4">
                <!-- Manage your restaurant menus effortlessly<br /> with our intuitive platform.<br /> -->
                Get your digital menu up and running quickly with our intuitive platform
            </p>
            <div class="flex items-center gap-2">
                <a href="pages/login.php" class="px-6 py-2 rounded-lg bg-slate-200 text-lg text-teal-800 font-semibold">Login</a>
                <a href="pages/signup.php" class="px-6 py-2 rounded-lg border border-white text-lg text-white font-semibold">Sign Up</a>
            </div>
        </div>

    </main>

    <!-- Explore Restaurants Menus-->

    <section class="bg-teal-100 py-12">
        <div class="max-w-[1500px] px-8 mx-auto">
            <h2 class="text-2xl font-semibold mb-6">Explore Restaurants</h2>

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
                exit;
            }

            // Fetch all restaurants
            $restaurants_query = "SELECT * FROM restaurants";
            $restaurants_result = pg_query($PG_CONN, $restaurants_query);

            $restaurants = pg_fetch_all($restaurants_result);
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- navigate to menu/id -->

                <?php foreach ($restaurants as $restaurant) : ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-2"><?= $restaurant['name'] ?></h3>
                        <p class="text-gray-600 mb-4"><?= $restaurant['address'] ?></p>
                        <a href="pages/menu.php?id=<?= $restaurant['id'] ?>" class="text-teal-900 text-sm px-4 py-[3px] font-semibold bg-teal-900/20 rounded-lg">View Menu</a>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </section>

    <!--import Footer -->

    <?php include('components/footer.php'); ?>


    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>