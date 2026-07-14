<?php
session_start();
if (!isset($_SESSION["admin"])) {
    exit("Acceso no permitido");
}

$productos = json_decode(file_get_contents("../productos.json"), true) ?: [];
$id_buscar = $_POST["id"];
$imagen_actual = $_POST["imagen_actual"];

// Si subieron una foto nueva
if (!empty($_FILES["foto"]["name"])) {
    // Borrar la foto anterior
    if (file_exists("../" . $imagen_actual)) {
        unlink("../" . $imagen_actual);
    }
    // Guardar la nueva
    $nombre_foto = time() . "_" . basename($_FILES["foto"]["name"]);
    move_uploaded_file($_FILES["foto"]["tmp_name"], "../imagenes/" . $nombre_foto);
    $ruta_final = "imagenes/" . $nombre_foto;
} else {
    // Dejar la misma foto
    $ruta_final = $imagen_actual;
}

// Actualizar los datos
foreach ($productos as &$p) {
    if ($p["id"] == $id_buscar) {
        $p["categoria"] = $_POST["categoria"];
        $p["nombre"] = $_POST["nombre"];
        $p["descripcion"] = $_POST["descripcion"];
        $p["precio"] = $_POST["precio"];
        $p["stock"] = $_POST["stock"];
        $p["imagen"] = $ruta_final;
        break;
    }
}

// Guardar todo en el archivo
file_put_contents("../productos.json", json_encode($productos, JSON_PRETTY_PRINT));

// Volver a la lista
header("Location: ver.php?exito=editado");
exit;
?>