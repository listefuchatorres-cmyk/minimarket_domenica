<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
require_once "../conexion.php";

// ✅ CAMBIAR A ENTREGADO
if (isset($_GET['entregar'])) {
    $id = intval($_GET['entregar']);
    mysqli_query($conexion, "UPDATE pedidos SET estado = 'entregado' WHERE id = $id");
    header("Location: pedidos.php");
    exit;
}

// ✅ ELIMINAR PEDIDO DEFINITIVAMENTE
if (isset($_GET['borrar'])) {
    $id = intval($_GET['borrar']);
    // Primero borramos el detalle para no dejar registros huérfanos
    mysqli_query($conexion, "DELETE FROM detalle_pedido WHERE pedido_id = $id");
    // Luego borramos el pedido principal
    mysqli_query($conexion, "DELETE FROM pedidos WHERE id = $id");
    header("Location: pedidos.php");
    exit;
}

// Obtener todos los pedidos, los nuevos primero
$pedidos = mysqli_query($conexion, "SELECT * FROM pedidos ORDER BY 
    CASE WHEN estado = 'pendiente' THEN 1 ELSE 2 END, fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Recibidos 📦</title>
    <link rel="stylesheet" href="../estilos.css">
    <style>
        .pendiente {color:#856404; background:#fff3cd; padding:4px 8px; border-radius:4px; font-weight:bold;}
        .entregado {color:#155724; background:#d4edda; padding:4px 8px; border-radius:4px; font-weight:bold;}
        .btn {padding:5px 10px; text-decoration:none; border-radius:4px; font-size:14px; margin:2px;}
        .btn-entregar {background:#28a745; color:white;}
        .btn-borrar {background:#dc3545; color:white;}
    </style>
</head>
<body>

<header>
    <h1>📦 Pedidos Recibidos de Clientes</h1>
</header>

<nav>
    <a href="ver.php">⬅ Volver a Productos</a>
    <a href="login.php?salir=1">🚪 Cerrar Sesión</a>
</nav>

<div class="container">
    <?php if(mysqli_num_rows($pedidos) == 0): ?>
        <p style="text-align:center; font-size:18px; color:#666; margin-top:50px;">Aún no hay pedidos nuevos.</p>
    <?php else: ?>
        <?php while ($p = mysqli_fetch_assoc($pedidos)): ?>
        <div style="border:1px solid #ccc; padding:15px; margin:15px 0; border-radius:6px;">
            <h3>
                Pedido N°<?= $p['id'] ?> 
                — Fecha: <?= date('d/m/Y H:i', strtotime($p['fecha'])) ?>
                <!-- ✅ ESTADO DEL PEDIDO -->
                <?php if ($p['estado'] == 'pendiente'): ?>
                    <span class="pendiente">⏳ Pendiente</span>
                <?php else: ?>
                    <span class="entregado">✅ Entregado</span>
                <?php endif; ?>
            </h3>
            <p><strong>Cliente:</strong> <?= $p['nombre_cliente'] ?></p>
            <p><strong>Teléfono:</strong> <?= $p['telefono'] ?></p>
            <p><strong>Dirección:</strong> <?= $p['direccion'] ?></p>
            <p style="font-weight:bold; color:#28a745;"><strong>TOTAL:</strong> $<?= number_format($p['total'],2) ?></p>
            
            <h4>📋 Productos pedidos:</h4>
            <?php
            $detalle = mysqli_query($conexion, "SELECT d.*, p.nombre FROM detalle_pedido d JOIN productos p ON d.producto_id = p.id WHERE d.pedido_id = {$p['id']}");
            while ($d = mysqli_fetch_assoc($detalle)) {
                echo "- {$d['nombre']} × {$d['cantidad']} = $" . number_format($d['subtotal'],2) . "<br>";
            }
            ?>

            <!-- ✅ BOTONES DE ACCIÓN -->
            <div style="margin-top:10px;">
                <?php if ($p['estado'] == 'pendiente'): ?>
                    <a href="pedidos.php?entregar=<?= $p['id'] ?>" class="btn btn-entregar" onclick="return confirm('¿Marcar este pedido como ENTREGADO?')">✅ Marcar Entregado</a>
                <?php endif; ?>
                <a href="pedidos.php?borrar=<?= $p['id'] ?>" class="btn btn-borrar" onclick="return confirm('¿Seguro que quieres ELIMINAR este pedido? No se puede recuperar.')">🗑️ Eliminar Pedido</a>
            </div>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

</body>
</html>