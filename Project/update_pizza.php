<?php
require 'db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $size = $_POST['size'];
    $current_image = $_POST['current_image'];

    if (!empty($_FILES['image']['name'])) {
        $filename = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $folder = "upload/";
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array(strtolower($file_extension), $allowed_types)) {
            $safe_filename = preg_replace("/[^a-zA-Z0-9.]/", "_", $filename);
            $target_filepath = $folder . $safe_filename;
            move_uploaded_file($temp_name, $target_filepath);
        } else {
            echo "Invalid file type.";
            exit;
        }
    } else {
        $safe_filename = $current_image;
    }

    $sql = "UPDATE pizzas SET name = ?, ingredients = ?, size = ?, image = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$name, $ingredients, $size, $safe_filename, $id])) {
        header('Location: index.php');
        exit;
    } else {
        echo "Failed to update pizza.";
    }
}
?>
