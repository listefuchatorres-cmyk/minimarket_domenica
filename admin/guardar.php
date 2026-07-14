<?php
session_start();

if (!isset($_SESSION["admin"])) {
    exit("Acceso no permitido");
}

require_once "../conexion.php";

// Crear carpeta si no existe
if (!file_exists("../imagenes")) {
    mkdir("../imagenes", 0755, true);
}

// Procesar imagen
$foto = $_FILES["foto"];
$nombre_foto = time() . "_" . basename($foto["name"]);
$ruta_foto = "imagenes/" . $nombre_foto;

if (!move_uploaded_file($foto["tmp_name"], "../" . $ruta_foto)) {
    die("❌ No se pudo subir la imagen");
}

// Obtener datos
$categoria = mysqli_real_escape_string($conexion, $_POST["categoria"]);
$nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
$descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
$precio = floatval($_POST["precio"]);
$stock = intval($_POST["stock"]); // ✅ Recibimos bien el stock

// ✅ CONSULTA CORREGIDA: Mismos campos y mismos valores, en ORDEN
$consulta = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria, imagen)
             VALUES ('$nombre', '$descripcion', $precio, $stock, '$categoria', '$ruta_foto')";

if (mysqli_query($conexion, $consulta)) {
    header("Location: agregar.php?exito=1");
} else {
    die("❌ Error en la consulta: " . mysqli_error($conexion));
}

exit;
?>