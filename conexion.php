<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$base_datos = "minimarket_domenica"; 

// Conectar
$conexion = mysqli_connect($servidor, $usuario, $clave, $base_datos);

// Verificar conexión
if (!$conexion) {
    die("❌ No se pudo conectar: " . mysqli_connect_error());
}

// Configurar caracteres
mysqli_set_charset($conexion, "utf8mb4");
?>