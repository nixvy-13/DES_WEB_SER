<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Heladería Heladitos</h1>
    <p>Modifique el stock del producto que quiera modificar: </p>
    <?php

    define("RUTA_STOCK_HELADOS", "stockHeladeria.data");

    if (file_exists(RUTA_STOCK_HELADOS)) {
        $stock = unserialize(file_get_contents(RUTA_STOCK_HELADOS));
    } else {
        $stock = [
            "Chocolate" => 28,
            "Pistacho" => 20,
            "Caramelo" => 23,
            "M&Ms" => 52,
            "Lotus" => 41,
            "Oreo" => 45,
            "Fresa" => 31,
            "Kiwi" => 38
        ];

        file_put_contents(RUTA_STOCK_HELADOS, serialize($stock));
    
    }

    $mensaje = "";
    $valido = true;
    if(isset($_POST["actualizar"])){
        foreach($stock as $producto => $cantidad){
            if($_POST["cantidad$producto"] === "" || $_POST["cantidad$producto"] < 0){
                $valido = false;
            }
        }

        foreach($stock as $producto => $cantidad){
            if($valido){
                $stock[$producto] = (int)$_POST["cantidad$producto"];
                $mensaje = "Stock actualizado correctamente";
            }else{
                $mensaje = "Por favor, introduzca un valor válido del stock de cada producto.";
            }
        }

        file_put_contents(RUTA_STOCK_HELADOS, serialize($stock));
    }

    ?>

    <form action="" method="post">
    <?php 
    
    foreach($stock as $producto => $cantidad){
        echo "<label>$producto </label>";
        echo "<input type'number' value='$cantidad' name='cantidad$producto'> <br>";
    }
    
    echo $mensaje . "<br>";

    ?>

    <input type="submit" name="actualizar" value="Actualizar Stock">

    </form>

</body>

</html>