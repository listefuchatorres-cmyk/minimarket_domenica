<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header>
    <h1>MiniMarket Domenica</h1>
    <p>Panel de Administración</p>
</header>

<nav>
    <a href="../index.html">🏪 Ir a la Tienda</a>
    <a href="ver.php">📋 Ver Productos</a>
    <a href="login.php?salir=1">🚪 Cerrar Sesión</a>
</nav>

<div class="container">
    <div class="form-contenedor">
        <h2 class="form-titulo">➕ Agregar Nuevo Producto</h2>

        <?php if (isset($_GET["exito"])): ?>
            <div class="mensaje exito">✅ Producto guardado correctamente</div>
        <?php endif; ?>

        <?php if (isset($_GET["error"])): ?>
            <div class="mensaje error">❌ Hubo un error al guardar</div>
        <?php endif; ?>

        <form action="guardar.php" method="POST" enctype="multipart/form-data">
            <div class="form-grupo">
                <label>Nombre del producto:</label>
                <input type="text" name="nombre" required placeholder="Ej: Aceite de girasol 1L">
            </div>

            <div class="form-grupo">
                <label>Descripción:</label>
                <textarea name="descripcion" rows="3" placeholder="Escribe aquí una breve descripción..."></textarea>
            </div>

            <div class="form-grupo">
                <label>Precio ($):</label>
                <input type="number" step="0.01" min="0" name="precio" required placeholder="Ej: 2.50">
            </div>

            <div class="form-grupo">
                <label>Stock disponible:</label>
                <input type="number" min="0" name="stock" required placeholder="Ej: 10, 25, 50">
            </div>

            <div class="form-grupo">
                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="">-- Selecciona una categoría --</option>
                    <option value="consumo">Productos de Consumo</option>
                    <option value="relojes">Relojes y Accesorios</option>
                    <option value="tecnologia">Artículos Tecnológicos</option>
                    <option value="ropa">Ropa y Calzado</option>
                    <option value="hogar">Artículos para el Hogar</option>
                    <option value="maquillaje">Maquillaje</option>
                    <option value="lencería">Lencería</option>
                    
                </select>
            </div>

            <div class="form-grupo">
                <label>Imagen del producto:</label>
                <input type="file" name="foto" accept="image/*" required>
            </div>

            <button type="submit" class="btn-guardar">💾 Guardar Producto</button>
        </form>
    </div>
</div>

<footer>
    <p>📍 Parroquia Peñaherrera, Cotacachi, Imbabura - Ecuador</p>
    <p>📞 0962336207 | ✉ minimarketdomenica@gmail.com</p>
    <p>© 2026 Todos los derechos reservados</p>
</footer>

</body>
</html>