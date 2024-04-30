<?php
require 'db_con.php'; 
$pizza_id = $_GET['id'] ?? null;

if (!$pizza_id) {
    header('Location: index.php'); 
    exit;
}

$sql = "SELECT id, name, ingredients, size, image FROM pizzas WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$pizza_id]);
$pizza = $stmt->fetch();

if (!$pizza) {
    header('Location: index.php'); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pizza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Pizza</h1>
    <form action="update_pizza.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($pizza['id']) ?>">
        <input type="text" name="name" placeholder="Pizza Name" required value="<?= htmlspecialchars($pizza['name']) ?>">
        <input type="text" name="ingredients" placeholder="Ingredients" required value="<?= htmlspecialchars($pizza['ingredients']) ?>">
        <select name="size" required>
            <option value="Small" <?= $pizza['size'] == 'Small' ? 'selected' : '' ?>>Small</option>
            <option value="Medium" <?= $pizza['size'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="Large" <?= $pizza['size'] == 'Large' ? 'selected' : '' ?>>Large</option>
        </select>
        <img src="upload/<?= htmlspecialchars($pizza['image']) ?>" alt="Pizza Image" height="100">
        <input type="file" name="image"> 
        <button type="submit">Update Pizza</button>
    </form>
</body>
</html>
