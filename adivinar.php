<?php
if (isset($_GET["num_hidden"]) && !empty($_GET["num_hidden"])) {
    $num_secreto = $_GET["num_hidden"];
} else {
    $num_secreto = rand(1, 10);
}

if (isset($_GET["num_intentos"]) && !empty($_GET["num_intentos"])) {
    $num_intentos = $_GET["num_intentos"];
} else {
    $num_intentos = 0;
}

if (isset($_REQUEST["numero"]) && !empty($_REQUEST["numero"])) {
    $intento = $_REQUEST["numero"];
    $num_intentos +=1;
    if ($intento > $num_secreto && !empty($intento)) {
        echo "El número secreto es MENOR";
    } elseif ($intento < $num_secreto && !empty($intento)) {
        echo "El número secreto es MAYOR";
    } elseif ($intento == $num_secreto && !empty($intento)) {
        echo "Lo has adivinado en $num_intentos intentos    ";
        $num_secreto = rand(1, 10);
        echo '<a href="adivinar.php">Volver a jugar</a>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adivina el Número</title>
</head>
<body>
    <form action="adivinar.php" method="get">
        <label for="">Introduce un número:</label>
        <input type="number" name="numero" required><br>
        <input type="hidden" name="num_hidden" value="<?php echo $num_secreto; ?>">
        <input type="hidden" name="num_intentos" value="<?php echo $num_intentos?>">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>