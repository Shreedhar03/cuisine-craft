<?php

// Get the menu ID from the URL parameter
$menuId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// For demonstration, let's use a placeholder array for menu items
$menus = [
    1 => ['name' => 'Bruschetta', 'description' => 'Grilled bread topped with tomatoes and basil', 'price' => 6.99],
    2 => ['name' => 'Caesar Salad', 'description' => 'Crisp romaine lettuce with Caesar dressing', 'price' => 8.99],
    3 => ['name' => 'Spaghetti Carbonara', 'description' => 'Pasta with creamy sauce and pancetta', 'price' => 12.99]
];

$menuItems = isset($menus[$menuId]) ? $menus[$menuId] : null;

if ($menuItems === null) {
    echo "Menu not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Menu Details</title>
</head>

<body>
    <h1>Menu Details</h1>
    <h2><?= htmlspecialchars($menuItems['name']) ?></h2>
    <p><?= htmlspecialchars($menuItems['description']) ?></p>
    <p>Price: $<?= htmlspecialchars($menuItems['price']) ?></p>
</body>

</html>