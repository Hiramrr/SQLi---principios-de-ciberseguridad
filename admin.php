<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"]) || $_SESSION["user"] !== "admin") {
    header("Location: index.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] === "create") {
            $name = $_POST["name"];
            $desc = $_POST["description"];
            $img = $_POST["image"];
            $cat = $_POST["category"];

            $stmt = $conn->prepare(
                "INSERT INTO cats (name, description, image, category) VALUES (?, ?, ?, ?)",
            );
            $stmt->bind_param("ssss", $name, $desc, $img, $cat);

            if ($stmt->execute()) {
                $message = "¡Michi agregado exitosamente!";
            } else {
                $message = "Error al agregar michi: " . $conn->error;
            }
            $stmt->close();
        } elseif ($_POST["action"] === "delete") {
            $id = $_POST["id"];
            $stmt = $conn->prepare("DELETE FROM cats WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Michi eliminado.";
            } else {
                $message = "Error al eliminar: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Fetch all cats for list
$cats = $conn->query("SELECT * FROM cats ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrar Michis</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #8B4513;
            font-weight: bold;
        }

        .cat-list {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cat-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .cat-info {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .btn-delete {
            background-color: #ff4444;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 15px;
            cursor: pointer;
            font-family: 'Fredoka One', cursive;
        }

        .btn-delete:hover {
            background-color: #cc0000;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #FFDAB9;
            border-radius: 10px;
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>

<body>

    <header>
        <h1>🛠️ Panel de Administración</h1>
        <div style="position: absolute; right: 20px; top: 20px;">
            <a href="index.php" class="admin-link" style="position: static;">← Volver al Santuario</a>
        </div>
    </header>

    <div class="admin-container">

        <?php if ($message): ?>
            <div class="message" style="margin-bottom: 20px; text-align: center; color: green; background: #e8f5e9;">
                <?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Create Form -->
        <div class="form-card">
            <h2 style="color: #8B4513; margin-top: 0;">Agregar Nuevo Michi</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <textarea name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>URL de Imagen:</label>
                    <input type="text" name="image" required placeholder="https://...">
                </div>
                <div class="form-group">
                    <label>Categoría:</label>
                    <select name="category">
                        <option value="General">General</option>
                        <option value="Kitten">Kitten</option>
                        <option value="Senior">Senior</option>
                        <option value="Mystic">Mystic</option>
                        <option value="Royal">Royal</option>
                        <option value="Ninja">Ninja</option>
                    </select>
                </div>
                <button type="submit" class="search-button" style="width: 100%;">Agregar Michi</button>
            </form>
        </div>

        <div class="cat-list">
            <h2 style="color: #8B4513; margin-top: 0;">Gestionar Michis Existentes</h2>
            <?php while ($row = $cats->fetch_assoc()): ?>
                <div class="cat-item">
                    <div class="cat-info">
                        <img src="<?php echo htmlspecialchars(
                            $row["image"],
                        ); ?>" alt="cat">
                        <div>
                            <strong><?php echo htmlspecialchars(
                                $row["name"],
                            ); ?></strong>
                            <span
                                style="color: #666; font-size: 0.9em;">(<?php echo htmlspecialchars(
                                    $row["category"],
                                ); ?>)</span>
                        </div>
                    </div>
                    <form method="POST" action="" onsubmit="return confirm('¿Seguro que quieres borrar a este michi?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $row[
                            "id"
                        ]; ?>">
                        <button type="submit" class="btn-delete">Eliminar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>

</html>
