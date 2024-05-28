<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <link rel="stylesheet" href="global.css">
    <!-- scaling -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <main class="bg-teal-900 h-[75vh] flex flex-col justify-center">

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
                <a href="login.php" class="px-6 py-2 rounded-lg bg-slate-200 text-lg text-teal-800 font-semibold">Login</a>
                <a href="signup.php" class="px-6 py-2 rounded-lg border border-white text-lg text-white font-semibold">Sign Up</a>
            </div>
        </div>

    </main>

    <!-- Explore Restaurants Menus-->

    <section class="bg-teal-100 py-12">
        <div class="max-w-[1500px] px-8 mx-auto">
            <h2 class="text-2xl font-semibold mb-6">Explore Restaurants Menus</h2>

            <?php
            $restaurants = [
                ['id' => 1, 'name' => 'Restaurant 1', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam, voluptates.'],
                ['id' => 2, 'name' => 'Restaurant 2', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam, voluptates.'],
                ['id' => 3, 'name' => 'Restaurant 3', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam, voluptates.']
            ];
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- navigate to menu/id -->

                <?php foreach ($restaurants as $restaurant) : ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-2"><?= $restaurant['name'] ?></h3>
                        <p class="text-gray-600 mb-4"><?= $restaurant['description'] ?></p>
                        <a href="menu.php?id=<?= $restaurant['id'] ?>" class="text-teal-800 rounded-lg">View Menu</a>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </section>


    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>