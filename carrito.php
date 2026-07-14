<?php
session_start();
require_once "conexion.php";

// ✅ AGREGAR PRODUCTO AL CARRITO
if (isset($_GET['agregar'])) {
    $id = intval($_GET['agregar']);
    $buscar = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id AND stock > 0");
    $producto = mysqli_fetch_assoc($buscar);

    if ($producto) {
        // Crear carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si ya está en el carrito, aumentar cantidad sin pasar el stock
        if (isset($_SESSION['carrito'][$id])) {
            if ($_SESSION['carrito'][$id]['cantidad'] < $producto['stock']) {
                $_SESSION['carrito'][$id]['cantidad']++;
            }
        } else {
            // Agregar nuevo producto
            $_SESSION['carrito'][$id] = [
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen'],
                'cantidad' => 1,
                'stock_max' => $producto['stock']
            ];
        }
    }
    header("Location: carrito.php");
    exit;
}

// ✅ QUITAR UN PRODUCTO
if (isset($_GET['quitar'])) {
    $id = intval($_GET['quitar']);
    unset($_SESSION['carrito'][$id]);
    header("Location: carrito.php");
    exit;
}

// ✅ VACIAR TODO EL CARRITO
if (isset($_GET['vaciar'])) {
    unset($_SESSION['carrito']);
    header("Location: carrito.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito 🛒 - MiniMarket Domenica</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        table {width:100%; border-collapse:collapse; margin:20px 0;}
        th, td {border:1px solid #ddd; padding:10px; text-align:center;}
        th {background:#f8f9fa;}
        .btn {padding:6px 12px; text-decoration:none; border-radius:4px;}
        .btn-quitar {background:#dc3545; color:white;}
        .btn-vaciar {background:#ff6b6b; color:white;}
        .btn-pedir {background:#28a745; color:white;}
        .btn-seguir {background:#007bff; color:white;}
    </style>
</head>
<body>

<header>
    <h1>MiniMarket Domenica 🛒 Tu Carrito</h1>
</header>

<nav>
    <a href="productos.php">🏪 Seguir Comprando</a>
    <a href="index.html">🏠 Inicio</a>
</nav>

<div class="container">
    <?php if (empty($_SESSION['carrito'])): ?>
        <h2 style="text-align:center; color:#666; margin-top:50px;">Tu carrito está vacío 😔</h2>
        <p style="text-align:center; font-size:18px;">Agrega productos desde nuestras categorías</p>
        <p style="text-align:center;"><a href="productos.php" class="btn btn-seguir">Ir a Comprar</a></p>
    <?php else: ?>

    <table>
        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
        <?php $total_final = 0; ?>
        <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
        <tr>
            <td><img src="<?= $item['imagen'] ?>" style="width:50px; height:auto;"></td>
            <td><?= $item['nombre'] ?></td>
            <td>$<?= number_format($item['precio'],2) ?></td>
            <td><?= $item['cantidad'] ?> / <?= $item['stock_max'] ?></td>
            <td>$<?= number_format($item['precio'] * $item['cantidad'],2) ?></td>
            <td><a href="carrito.php?quitar=<?= $id ?>" class="btn btn-quitar">Quitar</a></td>
        </tr>
        <?php $total_final += $item['precio'] * $item['cantidad']; ?>
        <?php endforeach; ?>

        <tr>
            <td colspan="4" style="text-align:right; font-weight:bold; font-size:17px;">TOTAL A PAGAR:</td>
            <td colspan="2" style="font-weight:bold; font-size:18px; color:#28a745;">$<?= number_format($total_final,2) ?></td>
        </tr>
    </table>

    <div style="text-align:center; margin-top:20px;">
        <a href="carrito.php?vaciar=1" class="btn btn-vaciar">🗑️ Vaciar Carrito</a>
        <a href="pedido.php" class="btn btn-pedir" style="margin-left:15px;">✅ Realizar Pedido</a>
    </div>

    <?php endif; ?>
</div>

</body>
</html>