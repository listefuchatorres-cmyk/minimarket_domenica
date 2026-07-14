<?php
require_once "conexion.php";
$lista = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'relojes' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relojes y Accesorios</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>MiniMarket Domenica</h1>
    <p>Relojes y Accesorios</p>
</header>

<nav>
    <a href="index.html">Inicio</a>
    <a href="productos.html">Productos</a>
    <a href="temu.html">Volver a Temu</a>
</nav>

<div class="container">
    <h2 class="section-title">⌚ Relojes y Accesorios</h2>
    <div class="cards">
        <?php if(empty($lista)): ?>
            <p style="width:100%; text-align:center; color:#666; padding:30px;">Aún no hay productos agregados.</p>
        <?php else: ?>
            <?php foreach ($lista as $p): ?>
            <div class="card">
                <img src="<?= $p["imagen"] ?>" alt="<?= $p["nombre"] ?>">
                <div class="card-content">
                    <h3><?= $p["nombre"] ?></h3>
                    <p><?= $p["descripcion"] ?></p>
                    <p><strong>Precio:</strong> $<?= number_format($p["precio"], 2) ?></p>
                    <?php if ($p["stock"] > 0): ?>
                        <p style="color:#28a745; font-weight:bold; margin: 6px 0;">📦 Disponibles: <?= $p["stock"] ?></p>
                    <?php else: ?>
                        <p style="color:#dc3545; font-weight:bold; margin: 6px 0;">❌ Agotado</p>
                    <?php endif; ?>
                    <?php if ($p["stock"] > 0): ?>
                        <a href="carrito.php?agregar=<?= $p['id'] ?>" style="display:inline-block; margin-top:8px; padding:6px 12px; background:#28a745; color:white; border-radius:4px; text-decoration:none;">🛒 Agregar al carrito</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>© 2026 MiniMarket Domenica</p>
</footer>

</body>
</html>