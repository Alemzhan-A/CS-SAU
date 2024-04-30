<?php
require 'db_con.php';
$sql = "SELECT id, name, ingredients, size, image FROM pizzas";
$stmt = $pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alsana's Pizza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome to Alsana's Pizza</h1>
        <p>Delicious pizza in Semey, located at Karagaily 1</p>
    </header>
    <section id="pizza-form">
    <form action="add_pizza.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Pizza Name" required>
    <input type="text" name="ingredients" placeholder="Ingredients" required>
    <select name="size" required>
        <option value="" disabled selected>Size</option>
        <option value="Small">Small</option>
        <option value="Medium">Medium</option>
        <option value="Large">Large</option>
    </select>
    <input type="file" name="image" required> 
    <button type="submit">Add Pizza</button>
    </form>
</section>
<section id="pizza-list">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Ingredients</th>
                <th>Size</th>
                <th>Image</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pizza = $stmt->fetch()): ?>
            <tr>
                <td><?= htmlspecialchars($pizza['id']) ?></td>
                <td><?= htmlspecialchars($pizza['name']) ?></td>
                <td><?= htmlspecialchars($pizza['ingredients']) ?></td>
                <td><?= htmlspecialchars($pizza['size']) ?></td>
                <td>
                
                <?php

                $imageSrc = (strpos($pizza['image'], 'upload/') === 0) ? $pizza['image'] : "upload/{$pizza['image']}";
                ?>
                <img src="<?= htmlspecialchars($imageSrc) ?>" alt="image" width="100" height="100">
            </td>
                <td>
                    <a href="edit_pizza.php?id=<?= $pizza['id'] ?>">Edit</a> | 
                    <a href="delete_pizza.php?id=<?= $pizza['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

</body>
</html>
