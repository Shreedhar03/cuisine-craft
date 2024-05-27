<!-- basic html php template -->

<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <!-- tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="global.css">
</head>

<body>

    <!-- php -->

    <!-- login page -->

    <div class="flex justify-center items-center h-screen bg-gray-200">
        <div class="bg-white p-16 rounded-lg shadow-lg flex flex-col items-center">
            <h2 class="text-4xl text-center font-bold mb-4 text-gray-800 logo">Cuisine Craft</h2>
            <p class="mb-8 text-xl">Login to your account</p>
            <form action="handlers/login.php" method="POST" class="w-72">
                <input type="email" autocomplete="FALSE" name="email" placeholder="Email" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <input type="password" autocomplete="FALSE" name="password" placeholder="Password" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <button type="submit" class="w-full text-center py-3 rounded bg-green-500 text-white hover:bg-green-400 focus:outline-none my-1">Login</button>
            </form>

            <!-- errors -->

            <?php
            session_start();
            // show logged in user
            if (isset($_SESSION['user'])) {
                echo "<p class='text-green-500 text-center'>Welcome " . $_SESSION['user']['name'] . "</p>";
                unset($_SESSION['user']);
            }
            if (isset($_SESSION['error'])) {
                echo "<p class='text-red-500 text-center'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>

            <p class="text-center mt-12">Don't have an account? <a href="index.php" class="font-semibold text-blue-500 hover:text-blue-400">Sign Up</a></p>
        </div>
    </div>

    <?php

    ?>

</body>