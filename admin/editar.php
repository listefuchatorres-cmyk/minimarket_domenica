<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

require_once "../conexion.php";

$id = intval($_GET["id"]);
$mensaje = "";

$consulta = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
$producto = mysqli_fetch_assoc($consulta);

if (!$producto) {
    die("❌ Producto no encontrado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
    $precio = floatval($_POST["precio"]);
    $stock = intval($_POST["stock"]);
    $categoria = mysqli_real_escape_string($conexion, $_POST["categoria"]);
    $imagen_actual = $producto["imagen"];

    if (!empty($_FILES["foto"]["name"])) {
        $nombre_foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $ruta_nueva = "imagenes/" . $nombre_foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], "../" . $ruta_nueva);

        if (file_exists("../" . $imagen_actual)) {
            unlink("../" . $imagen_actual);
        }

        $imagen_actual = $ruta_nueva;
    }

    $actualizar = "UPDATE productos 
                   SET nombre = '$nombre', descripcion = '$descripcion', precio = $precio, stock = $stock, categoria = '$categoria', imagen = '$imagen_actual'
                   WHERE id = $id";

    if (mysqli_query($conexion, $actualizar)) {
        $mensaje = "✅ Cambios guardados correctamente";
        $consulta = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
        $producto = mysqli_fetch_assoc($consulta);
    } else {
        $mensaje = "❌ Error: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header>
    <h1>Editar Producto</h1>
</header>

<nav>
    <a href="../index.html">🏪 Ir a la Tienda</a>
    <a href="ver.php">📋 Ver Productos</a>
    <a href="login.php?salir=1">🚪 Cerrar Sesión</a>
</nav>

<div class="container form-box">
    <?php if ($mensaje): ?>
        <p style="text-align:center; padding:10px; background:#f0fff4; border-radius:6px;"><?= $mensaje ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

        <label>Descripción:</label>
        <textarea name="descripcion" rows="3"><?= htmlspecialchars($producto['descripcion']) ?></textarea>

        <label>Precio ($):</label>
        <input type="number" step="0.01" min="0" name="precio" value="<?= $producto['precio'] ?>" required>

        <label>Stock disponible:</label>
        <input type="number" min="0" name="stock" value="<?= $producto['stock'] ?>" required>

        <label>Categoría:</label>
        <select name="categoria" required>
            <option value="">-- Selecciona --</option>
            <option value="consumo" <?= ($producto['categoria'] == 'consumo') ? 'selected' : '' ?>>Productos de Consumo</option>
            <option value="relojes" <?= ($producto['categoria'] == 'relojes') ? 'selected' : '' ?>>Relojes y Accesorios</option>
            <option value="tecnologia" <?= ($producto['categoria'] == 'tecnologia') ? 'selected' : '' ?>>Artículos Tecnológicos</option>
            <option value="ropa" <?= ($producto['categoria'] == 'ropa') ? 'selected' : '' ?>>Ropa y Calzado</option>
            <option value="hogar" <?= ($producto['categoria'] == 'hogar') ? 'selected' : '' ?>>Artículos para el Hogar</option>
            <option value="lencería" <?= $producto["categoria"] == 'Lencería' ? 'selected' : '' ?>>Lencería</option>
            <option value="maquillaje" <?= $producto["categoria"] == 'Maquillaje' ? 'selected' : '' ?>>Maquillaje</option>
        </select>

        <p>Imagen actual:</p>
        <img src="../<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen actual" style="max-width:150px; margin:10px 0; border-radius:6px;">

        <label>Cambiar imagen (opcional):</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit">💾 Guardar Cambios</button>
    </form>
</div>

</body>
</html>