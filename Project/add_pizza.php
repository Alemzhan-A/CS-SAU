<?php
require 'db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];
    $folder = "upload/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array(strtolower($file_extension), $allowed_types)) {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        exit;
    }
    $safe_filename = preg_replace("/[^a-zA-Z0-9.]/", "_", $filename);
    $target_filepath = $folder . $safe_filename;
    if (move_uploaded_file($temp_name, $target_filepath)) {
        $db_filepath = $folder . $safe_filename;
        $sql = "INSERT INTO pizzas (name, ingredients, size, image) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$_POST['name'], $_POST['ingredients'], $_POST['size'], $db_filepath])) {
            echo "Pizza added successfully with image.";
        } else {
            echo "Error: Failed to add pizza to database.";
        }
    } else {
        echo "Failed to upload image.";
    }
    header("Location: index.php");
    exit();
}
?>
