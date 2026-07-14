<?php session_start();
$clave_correcta = "miclave123";

if ($_POST) {
    if ($_POST["clave"] === $clave_correcta) {
        $_SESSION["admin"] = true;
        header("Location: agregar.php");
        exit;
    } else {
        $error = "❌ Contraseña incorrecta";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Administrador</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<div class="container">
    <div class="login-box">
        <h2 style="text-align:center; color:#ff7b00;">🔑 Acceso al Panel</h2>
        <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
        <form method="post">
            <input type="password" name="clave" placeholder="Escribe tu contraseña" required style="width:100%; padding:12px; margin:15px 0; border:1px solid #ddd; border-radius:4px; font-size:16px;">
            <button type="submit" style="width:100%; padding:12px; background:#ff7b00; color:white; border:none; border-radius:4px; font-size:16px; cursor:pointer;">Ingresar</button>
        </form>
    </div>
</div>
</body>
</html>