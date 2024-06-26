<!-- basic html php template -->

<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <!-- tailwind -->
    <link rel="stylesheet" href="../global.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <!-- php -->

    <!-- login page -->

    <div class="flex justify-center items-center h-screen bg-teal-100/50">
        <div class="bg-white p-16 rounded-lg shadow-lg flex flex-col items-center">
            <?php include('../components/logo.php'); ?>
            <p class="mb-8 text-xl">Login to your account</p>
            <form action="../handlers/login.php" method="POST" class="w-72">
                <input type="email" autocomplete="FALSE" name="email" placeholder="Email" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <input type="password" autocomplete="FALSE" name="password" placeholder="Password" class="block border border-grey-light w-full p-3 rounded mb-4" required>
                <button type="submit" class="w-full text-center py-3 rounded-lg bg-teal-900 text-white hover:bg-teal-700 focus:outline-none my-1">Login</button>
            </form>

            <!-- errors -->

            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<p class='text-red-500 text-center'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>

            <p class="text-center mt-12">Don't have an account? <a href="signup.php" class="font-semibold text-blue-500 hover:text-blue-400">Sign Up</a></p>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>

</body>