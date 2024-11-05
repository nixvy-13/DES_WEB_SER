<?php
define("RUTA_USUARIOS", "usuarios.data");
$usuarios = [
    'usuario' => password_hash('1234'),
    'administrador' => password_hash('admin')
];
file_put_contents(RUTA_USUARIOS, serialize($usuarios))

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <form action="login.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>

    <?php
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombreUsuario = $_POST['username'];
        $contraseñaIngresada = $_POST['password'];
        
        // Cargar el archivo de usuarios serializado
        if (file_exists(RUTA_USUARIOS)) {
            $usuarios = unserialize(file_get_contents(RUTA_USUARIOS));
            
            // Verificar si el usuario existe y la contraseña es correcta
            if (isset($usuarios[$nombreUsuario]) && password_verify($contraseñaIngresada, $usuarios[$nombreUsuario])) {
                // Autenticación exitosa
                $_SESSION['autenticado'] = true;
                $_SESSION['usuario'] = $nombreUsuario;
                header("Location: dashboard.php");
                exit();
            } else {
                // Autenticación fallida
                echo "<p>Usuario o contraseña incorrectos.</p>";
            }
        } else {
            echo "<p>Error: archivo de usuarios no encontrado.</p>";
        }
    }
    ?>
</body>
</html>
