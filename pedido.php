<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $total = 0;

    // Calcular total
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Guardar pedido principal
    mysqli_query($conexion, "INSERT INTO pedidos (nombre_cliente, telefono, direccion, total) VALUES ('$nombre', '$telefono', '$direccion', $total)");
    $id_pedido = mysqli_insert_id($conexion);

    // Guardar detalle y DESCONTAR STOCK
    foreach ($_SESSION['carrito'] as $id => $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        mysqli_query($conexion, "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES ($id_pedido, $id, {$item['cantidad']}, {$item['precio']}, $subtotal)");
        
        // ✅ RESTAR DEL STOCK
        mysqli_query($conexion, "UPDATE productos SET stock = stock - {$item['cantidad']} WHERE id = $id");
    }

    // Vaciar carrito después de comprar
    unset($_SESSION['carrito']);
    echo "<script>alert('🎉 ¡Pedido realizado con éxito! Nos comunicaremos pronto contigo.'); window.location='index.html';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido 📝</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .form-pedido {max-width:500px; margin:30px auto; padding:20px; border:1px solid #ddd; border-radius:8px;}
        .form-pedido label {display:block; margin:10px 0 5px; font-weight:bold;}
        .form-pedido input, .form-pedido textarea {width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;}
        .btn-enviar {background:#28a745; color:white; padding:10px 20px; border:none; border-radius:4px; font-size:16px; margin-top:15px; cursor:pointer;}
    </style>
</head>
<body>

<header>
    <h1>📝 Finalizar tu Pedido</h1>
</header>

<div class="container form-pedido">
    <form method="POST">
        <label>Tu Nombre Completo:</label>
        <input type="text" name="nombre" required>

        <label>Tu Teléfono:</label>
        <input type="tel" name="telefono" required>

        <label>Dirección de Entrega:</label>
        <textarea name="direccion" rows="4" required></textarea>

        <button type="submit" class="btn-enviar">✅ Confirmar y Enviar Pedido</button>
    </form>
</div>

</body>
</html>