<?php 
session_start();
define("RUTA_USUARIOS", "usuarios.data");
// Comprobar si se necesita crear el archivo de usuarios
if (!file_exists("usuarios.data")) {
    $usuarios = [
        'usuario' => password_hash('1234', PASSWORD_DEFAULT),
        'administrador' => password_hash('admin', PASSWORD_DEFAULT),
        'Ivyel' => password_hash('ivy', PASSWORD_DEFAULT)
    ];
    file_put_contents(RUTA_USUARIOS, serialize($usuarios));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>
    
    <!-- Formulario para iniciar sesión -->
    <form action="" method="POST">
        <label for="user">Usuario:</label>
        <input type="text" name="user" id="user">
        <br>
        <label for="pswd">Contraseña:</label>
        <input type="password" name="pswd" id="pswd">
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <br><br>
    <a href="registro.php">Registrate</a>
    <br><br>
    <?php
    if (isset($_POST['cierre_sesion'])) {
        session_unset(); // Eliminar todas las variables de sesión
        session_destroy(); // Destruir la sesión
    }
    // Lógica de autenticación
    if (isset($_POST['user']) && $_POST['user'] != '') {
        $inputUser = $_POST['user'];
        $inputPswd = $_POST['pswd'];
        
        // Cargar el archivo de usuarios serializado
        if (file_exists(RUTA_USUARIOS)) {
            $usuarios = unserialize(file_get_contents(RUTA_USUARIOS));
            
            // Verificar si el usuario existe y la contraseña es correcta
            if (isset($usuarios[$inputUser]) && password_verify($inputPswd, $usuarios[$inputUser])) {
                // Autenticación exitosa
                $_SESSION['autenticado'] = true;
                $_SESSION['usuario'] = $inputUser;
                
                // Comprobar si el usuario es administrador
                if ($inputUser == 'administrador') {
                    $_SESSION['administrador'] = true; // Corregido para establecer la sesión del administrador
                    echo '<a href="carritoAdmin.php">Gestiona</a> <br>';   
                }
                echo '<a href="carritoAvanzado.php">Compra</a>';
                
            } else {
                // Autenticación fallida
                echo "<p>Usuario o contraseña incorrectos.</p>";
            }
        } else {
            echo "<p>Error: archivo de usuarios no encontrado.</p>";
        }
    }
    if($_SESSION['autenticado']){
        echo '<form action="autenticacion.php" method="post">
        <input type="submit" name="cierre_sesion" value="cerrar_sesion">
        </form>';
    }
    ?>
</body>
</html>
