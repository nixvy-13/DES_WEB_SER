<?php session_start()?>
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

    define("RUTA_STOCK_FRED", "stockFred.data");

    if (file_exists(RUTA_STOCK_FRED)) {
        $stock = unserialize(file_get_contents(RUTA_STOCK_FRED));
    } else {
        $stock = [
            "Pan" => 20,
            "Perla" => 15,
            "Sandia" => 23,
            "Pocion" => 30,
            "Libro" => 9,
            "Cubo" => 16,
            "Hierro" => 17,
            "Zanahoria" => 22
        ];

        file_put_contents(RUTA_STOCK_FRED, serialize($stock));
    
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

        file_put_contents(RUTA_STOCK_FRED, serialize($stock));
    }

    ?>

    <form action="" method="post">
    <?php 
    
    foreach($stock as $producto => $cantidad){
        echo "<label>$producto </label>";
        echo "<input type'number' value='$cantidad' name='cantidad$producto'> <br>";
    }
    
    echo $mensaje . "<br>";

    if($_SESSION['administrador']){
        echo '<input type="submit" name="actualizar" value="Actualizar Stock">';
    }else{
        echo '<a href="autenticacion.php">Inicia Sesion</a>'; 
    }   
    ?>
    </form>
    <?php 
    if($_SESSION['autenticado']){
        echo '<form action="autenticacion.php" method="post">
        <input type="submit" name="cierre_sesion" value="cerrar_sesion">
        </form>';
    }
    ?>
    <a href="carritoAvanzado.php">Compra</a>
</body>

</html>