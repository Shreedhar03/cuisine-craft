<!-- handle multiple images uploading -->

<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['restaurant_id']) {

        echo "alert('inside upload_images.php')";

        $restaurant_id = $_SESSION['restaurant_id'];
        $images = $_FILES["images"];

        $image_names = [];
        $image_paths = [];

        foreach ($images["name"] as $key => $image_name) {
            $image_tmp_name = $images["tmp_name"][$key];
            $image_path = "../uploads/" . $image_name;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $image_names[] = $image_name;
                $image_paths[] = $image_path;
            }
        }

        if (count($image_names) > 0) {
            $insert_images_query = "INSERT INTO images (name, path, restaurant_id) VALUES ";
            $values = [];

            foreach ($image_names as $key => $image_name) {
                $values[] = "('$image_name', '$image_paths[$key]', $restaurant_id)";
            }

            $insert_images_query .= implode(", ", $values);

            $insert_images_result = pg_query($PG_CONN, $insert_images_query);

            if ($insert_images_result) {
                $_SESSION['success'] = "Images uploaded successfully";
                header("Location: ../pages/user.php");
                exit;
            } else {
                $_SESSION['error'] = "Error: Unable to upload images";
                echo "alert('Error: Unable to upload images')";
                header("Location: ../pages/user.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Error: No images uploaded";
            echo "alert('Error: No images uploaded')";
            header("Location: ../pages/user.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Error: Invalid request";
        echo "alert('Error: Invalid request')";
        header("Location: ../pages/user.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Error: Invalid request method";
    echo "alert('Error: Invalid request method')";
    header("Location: ../pages/user.php");
    exit;
}
