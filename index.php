<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santuario de Michis</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>🐱 Santuario de Michis</h1>
        <?php if (isset($_SESSION["user"])): ?>
            <div style="position: absolute; right: 20px; top: 20px;">
                <span style="color: #8B4513; font-weight: bold; margin-right: 15px;">Hola,
                    <?php echo htmlspecialchars($_SESSION["user"]); ?></span>
                <?php if ($_SESSION["user"] === "admin"): ?>
                    <a href="admin.php" class="admin-link"
                        style="position: static; background-color: #FFA500; color: white; margin-right: 10px;">Administrar
                        Michis</a>
                <?php endif; ?>
                <a href="logout.php" class="admin-link" style="position: static;">Cerrar Sesión</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="admin-link">Iniciar Sesión</a>
        <?php endif; ?>
    </header>

    <div class="search-container">
        <form class="search-form" action="index.php" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Buscar michi por nombre..."
                value="<?php echo isset($_GET["search"])
                    ? htmlspecialchars($_GET["search"])
                    : ""; ?>">
            <button type="submit" class="search-button">Buscar</button>
        </form>
    </div>

    <div class="categories">
        <a href="index.php" class="category-tag">Todos</a>
        <a href="index.php?category=Kitten" class="category-tag">Gatitos</a>
        <a href="index.php?category=Senior" class="category-tag">Mayores</a>
        <a href="index.php?category=Mystic" class="category-tag">Místicos</a>
        <a href="index.php?category=Royal" class="category-tag">Realeza</a>
    </div>

    <div class="container">
        <?php
        $search = isset($_GET["search"]) ? $_GET["search"] : "";
        $category = isset($_GET["category"]) ? $_GET["category"] : "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";

        if ($id) {
            $sql = "SELECT * FROM cats WHERE id = $id";
        } elseif ($search) {
            $sql = "SELECT * FROM cats WHERE name LIKE '%" . $search . "%'";
        } elseif ($category) {
            $sql = "SELECT * FROM cats WHERE category = '$category'";
        } else {
            $sql = "SELECT * FROM cats";
        }

        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card">';
                            echo '<img src="' . $row["image"] . '" alt="Cat">';
                            echo '<div class="card-content">';
                            echo "<h2>" . $row["name"] . "</h2>";
                            echo "<p>" . $row["description"] . "</p>";
                            if (isset($row["category"])) {
                                echo '<span class="category-label">' .
                                    htmlspecialchars($row["category"]) .
                                    "</span>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        if (!$conn->more_results()) {
                            echo "<div class='no-results'>No se encontraron michis 😿</div>";
                        }
                    }
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            echo "<div class='no-results'>Error en la consulta: " .
                $conn->error .
                "</div>";
        }
        ?>
    </div>

</body>

</html>
