<?php
session_start();

// Inicializa variables para manejar errores y datos de archivo
$error = "";
$file_info = [];
$upload_dir = 'uploads/'; // Directorio donde se guardarán los archivos

// Asegúrate de que el directorio de carga exista
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Maneja la carga del archivo
if (isset($_POST['submit'])) {
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['file_upload']['tmp_name'];
        $name = basename($_FILES['file_upload']['name']);
        $size = $_FILES['file_upload']['size'];

        // Mueve el archivo a la carpeta de carga
        $file_path = $upload_dir . $name;
        if (move_uploaded_file($tmp_name, $file_path)) {
            // Archivo cargado correctamente
            $file_info = [
                'name' => $name,
                'size' => $size,
                'path' => $file_path,
            ];
        } else {
            $error = "Error al mover el archivo.";
        }
    } else {
        $error = "No se pudo cargar el archivo. Error: " . $_FILES['file_upload']['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo</title>
</head>
<body>
    <h1>Subir Archivo</h1>

    <!-- Formulario para subir el archivo -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="file_upload">Selecciona un archivo para subir:</label>
        <input type="file" name="file_upload" id="file_upload" required>
        <button type="submit" name="submit">Subir</button>
    </form>

    <!-- Mostrar información del archivo si se cargó correctamente -->
    <?php if (!empty($file_info)): ?>
        <h2>Detalles del Archivo Subido</h2>
        <ul>
            <li><strong>Nombre:</strong> <?php echo htmlspecialchars($file_info['name']); ?></li>
            <li><strong>Tamaño:</strong> <?php echo $file_info['size']; ?> bytes</li>
            <li><strong>Ruta:</strong> <?php echo htmlspecialchars($file_info['path']); ?></li>
        </ul>
        <!-- Enlace para descargar el archivo -->
        <a href="<?php echo htmlspecialchars(urlencode($file_info['path'])); ?>" download>Descargar Archivo</a>
    <?php elseif ($error): ?>
        <h2>Error</h2>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
