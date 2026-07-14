<?php
require_once "conexion.php";
$consulta = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'consumo' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos de Consumo - MiniMarket Domenica</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>MiniMarket Domenica</h1>
    <p>Productos de uso diario</p>
</header>

<nav>
    <a href="index.html">Inicio</a>
    <a href="productos.php">Productos</a>
    <a href="carrito.php">🛒 Ver Carrito</a> <!-- ✅ Agregué enlace al carrito -->
    <a href="index.html#nosotros">Nosotros</a>
    <a href="index.html#contacto">Contacto</a>
</nav>

<div class="container">
    <h2 class="section-title">🛒 Productos de Consumo</h2>
    <div class="cards">
        <?php if(mysqli_num_rows($consulta) == 0): ?>
            <p style="width:100%; text-align:center; color:#666; padding:40px; font-size:18px;">Aún no hay productos registrados.</p>
        <?php else: ?>
            <!-- ✅ BUCLE CORRECTO: lee uno por uno sin errores -->
            <?php while ($p = mysqli_fetch_assoc($consulta)): ?>
            <div class="card">
                <img src="<?= $p["imagen"] ?>" alt="<?= $p["nombre"] ?>">
                <div class="card-content">
                    <h3><?= $p["nombre"] ?></h3>
                    <p><?= $p["descripcion"] ?></p>
                    <p><strong>Precio: $<?= number_format($p["precio"], 2) ?></strong></p>
                    
                    <!-- ✅ STOCK + BOTÓN AGREGAR AL CARRITO -->
                    <?php if ($p["stock"] > 0): ?>
                        <p style="color:#28a745; font-weight:bold; margin: 6px 0;">📦 Disponibles: <?= $p["stock"] ?></p>
                        <a href="carrito.php?agregar=<?= $p["id"] ?>" style="display:inline-block; margin-top:8px; padding:6px 12px; background:#28a745; color:white; border-radius:4px; text-decoration:none;">🛒 Agregar al carrito</a>
                    <?php else: ?>
                        <p style="color:#dc3545; font-weight:bold; margin: 6px 0;">❌ Agotado</p>
                    <?php endif; ?>
                    
                </div>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>© 2026 MiniMarket Domenica - Todos los derechos reservados</p>
</footer>

</body>
</html>