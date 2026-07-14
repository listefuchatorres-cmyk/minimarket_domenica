<?php
require_once "conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniMarket Domenica - Productos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>MiniMarket Domenica</h1>
    <p>Víveres y Productos Temu</p>
</header>

<nav>
    <a href="index.html">Inicio</a>
    <a href="productos.php">Productos</a>
    <a href="temu.html">Temu</a>
    <a href="index.html#nosotros">Nosotros</a>
    <a href="index.html#contacto">Contacto</a>
</nav>

<div class="container">
    <h2 class="section-title">Nuestras Categorías</h2>
    <div class="cards">
        <a href="consumo.php" class="card-link">
            <div class="card">
                <img src="https://images.unsplash.com/photo-1579113800032-c38bd7635818?q=80&w=1200" alt="Productos de consumo">
                <div class="card-content">
                    <h3>Productos de Consumo</h3>
                    <p>Víveres, bebidas, limpieza y artículos básicos.</p>
                </div>
            </div>
        </a>
        <a href="temu.html" class="card-link">
            <div class="card">
                <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?q=80&w=1200" alt="Productos Temu">
                <div class="card-content">
                    <h3>Productos Temu</h3>
                    <p>Ropa, accesorios, tecnología y artículos importados.</p>
                </div>
            </div>
        </a>
    </div>
</div>

<footer>
    <p>📍 Parroquia Peñaherrera, Cotacachi, Imbabura - Ecuador</p>
    <p>📞 0962336207 | ✉ minimarketdomenica@gmail.com</p>
    <p>© 2026 Todos los derechos reservados</p>
</footer>

</body>
</html>