<?php
session_start(); // Iniciar la sesión

define("RUTA_USUARIOS", "usuarios.data");

// Comprobar si el archivo de usuarios existe, si no, crear uno vacío
if (!file_exists(RUTA_USUARIOS)) {
    $usuarios = [];
    file_put_contents(RUTA_USUARIOS, serialize($usuarios));
} else {
    // Cargar usuarios existentes
    $usuarios = unserialize(file_get_contents(RUTA_USUARIOS));
}

// Lógica de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoUsuario = ($_POST['usuario']);
    $nuevaContrasena = ($_POST['contrasena']);
    
    // Verificar que el nombre de usuario no esté vacío y no exista ya
    if ($nuevoUsuario !== '' && !isset($usuarios[$nuevoUsuario])) {
        // Agregar el nuevo usuario al array
        $usuarios[$nuevoUsuario] = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        
        // Guardar el array actualizado en el archivo
        file_put_contents(RUTA_USUARIOS, serialize($usuarios));
        
        echo "<p>Registro exitoso. Puedes <a href='autenticacion.php'>iniciar sesión</a>.</p>";
    } elseif (isset($usuarios[$nuevoUsuario])) {
        echo "<p>El nombre de usuario ya está en uso. Por favor, elige otro.</p>";
    } else {
        echo "<p>El nombre de usuario no puede estar vacío.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    
    <form action="" method="POST">
        <label for="usuario">Nombre de Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br>
        <input type="submit" value="Registrarse">
    </form>
    
    <br>
    <a href="autenticacion.php">Iniciar sesión</a>
</body>
</html>
