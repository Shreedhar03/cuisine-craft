<!DOCTYPE html>
<html>

<head>
    <title>Cuisine Craft</title>
    <link rel="stylesheet" href="global.css">
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

    $user_id = $_SESSION['user_id'];

    // Fetch user details
    $user_query = "SELECT * FROM users WHERE id = $user_id";
    $user_result = pg_query($PG_CONN, $user_query);

    $user = pg_fetch_assoc($user_result);

    // Fetch restaurant details

    $restaurant_id = $user['restaurant_id'];

    $restaurant_query = "SELECT * FROM restaurants WHERE id = $restaurant_id";
    $restaurant_result = pg_query($PG_CONN, $restaurant_query);
    $restaurant = pg_fetch_assoc($restaurant_result);

    ?>


    <main class="bg-teal-100/50">
        <div class="max-w-[1500px] mx-auto px-12 py-12 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold italic">
                    Welcome, <?php echo $user['name']; ?>
                </h2>
                <h1 class="text-4xl font-bold">
                    <?php echo $restaurant['name']; ?>
                </h1>
            </div>
            <button>
                <a href="handlers/logout.php" class="text-white bg-red-500 px-4 py-[4px] rounded mt-4">Logout</a>
            </button>
        </div>
    </main>


    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>