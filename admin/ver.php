<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

require_once "../conexion.php";

// Eliminar producto
if (isset($_GET["borrar"])) {
    $id = intval($_GET["borrar"]);
    $resultado = mysqli_query($conexion, "SELECT imagen FROM productos WHERE id = $id");
    $producto = mysqli_fetch_assoc($resultado);

    if ($producto && file_exists("../" . $producto["imagen"])) {
        unlink("../" . $producto["imagen"]);
    }

    mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
    header("Location: ver.php?aviso=1");
    exit;
}

// Obtener todos los productos
$productos = mysqli_query($conexion, "SELECT * FROM productos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos - MiniMarket Domenica</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header>
    <h1>Panel de Administración</h1>
</header>
<nav>
    <a href="../index.html">🏪 Ir a la Tienda</a>
    <a href="agregar.php">➕ Agregar Producto</a>
    <a href="login.php?salir=1">🚪 Cerrar Sesión</a>
</nav>

<div class="container">
    <h2 class="section-title">📋 Todos los Productos</h2>

    <?php if (isset($_GET["aviso"])): ?>
        <p style="text-align:center; color:green; background:#f0fff4; padding:10px; border-radius:6px; margin-bottom:20px;">✅ Operación realizada correctamente</p>
    <?php endif; ?>

    <?php if (mysqli_num_rows($productos) == 0): ?>
        <p style="text-align:center; color:#666; padding:60px; font-size:17px;">Aún no hay productos registrados.</p>
    <?php else: ?>
        <div class="lista-productos">
            <?php while ($p = mysqli_fetch_assoc($productos)): ?>
            <div class="tarjeta-producto">
                <img src="../<?= $p["imagen"] ?>" alt="<?= $p["nombre"] ?>">
                <div class="info-producto">
                    <h4><?= $p["nombre"] ?></h4>
                    <p class="descripcion"><?= htmlspecialchars($p["descripcion"]) ?></p>
                    <p>Categoría: 
                        <?php
                        $categorias = [
                            'Víveres' => 'Productos de Consumo',
                            'Relojes y Accesorios' => 'Relojes y Accesorios',
                            'Artículos Tecnológicos' => 'Artículos Tecnológicos',
                            'Ropa y Calzado' => 'Ropa y Calzado',
                            'Artículos para el Hogar' => 'Artículos para el Hogar',
                            'Lencería' => 'Lencería y Trajes de Baño',
                            'Maquillaje' => 'Maquillaje y Belleza'
                        ];
                        echo isset($categorias[$p["categoria"]]) ? $categorias[$p["categoria"]] : $p["categoria"];
                        ?>
                    </p>
                    <p class="precio">$<?= number_format($p["precio"], 2) ?></p>
                    <p class="stock" style="font-weight:bold; color:<?= $p['stock'] > 0 ? '#28a745' : '#dc3545'; ?>;">
                        📦 Stock: <?= $p["stock"] ?> disponibles
                    </p>
                </div>
                <div class="botones-acciones">
                    <a href="editar.php?id=<?= $p["id"] ?>" class="btn-editar">✏️ Editar</a>
                    <a href="ver.php?borrar=<?= $p["id"] ?>" class="btn-borrar" onclick="return confirm('¿Eliminar este producto?')">🗑️ Eliminar</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>© 2026 MiniMarket Domenica</p>
</footer>

</body>
</html>