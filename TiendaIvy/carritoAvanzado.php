<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Aldeano Fred</h1>

    <!-- En primer lugar inicializamos el Usuario -->
    <?php        
        if(isset($_POST["usuario"]) && $_POST["usuario"] !== ""){
            $_SESSION["usuario"] = $_POST["usuario"]; //Tenía que guardar el usuario 
            //en un $_SESSION porq si no al pulsar comprar desaparecía
        }

    // Damos la bienvenida al usuario dependiendo de si ha puesto un nombre o no

        if(isset($_SESSION["usuario"])){
            echo "<h3> Hola, ". $_SESSION['usuario']."! ¿Que deseas comprar?</h3>";
        }else{
            echo "<h3> Hola! ¿Que desea comprar?</h3>";
        }

    //Inicializamos un contador para que al introducir en el fichero de logs nuevas compras
    //de un mismo usuario se almacenen como diferentes compras
    //y no borre la anterior compra de ese usuario

        if(!isset($_SESSION["contador_log"])){
            $_SESSION["contador_log"] = 1;
        }
    
    ?>

    <p>Selecciona los items y la cantidad que deseas comprar:</p>
    <?php

    //Cada vez que se recarga la página el mensaje vuelve a estar vacío
    $mensaje = "";

    //Definimos las constantes al principio
    define("RUTA_STOCK_FRED", "stockFred.data");
    define("RUTA_LOGS", value: "fichLogs.data");

    //En el caso de que exista el fichero lo inicializamos, si no solo cogemos la información
    //que contiene
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
    $precios = [
        "Pan" => 2,
        "Perla" => 30,
        "Sandia" => 3,
        "Pocion" => 5,
        "Libro" => 20,
        "Cubo" => 10,
        "Hierro" => 4,
        "Zanahoria" => 3
    ];

    //Inicializo las "cantidadesSeleccionadas" a un array vacío
    if (!isset($_SESSION['cantidadesSeleccionadas'])) {
        $_SESSION['cantidadesSeleccionadas'] = [];  // Inicializar si no está en sesión
    }

    //Aquí actualizamos las cantidades seleccionadas
    foreach ($stock as $producto => $cantidad) {
        if (isset($_POST["cantidad$producto"])) {
            $_SESSION["cantidadesSeleccionadas"][$producto] = (int)$_POST["cantidad$producto"];
        }
    }

    //Aquí tenía el formulario

    //actualizamos el carrito
    $productosSeleccionados = [];
    if (isset($_POST["actualizar"])) {
        $total = 0;
        foreach ($precios as $producto => $precio) {
            if (!isset($_SESSION['cantidadesSeleccionadas'][$producto])) {
                $_SESSION['cantidadesSeleccionadas'][$producto] = 0; // Inicializar en 0 si no existe
            }
            //Si las cantidades seleccionadas son válidas
            if ($_SESSION['cantidadesSeleccionadas'][$producto] <= $stock[$producto] && $_SESSION['cantidadesSeleccionadas'][$producto] > -1) {
                $productosSeleccionados[$producto] = $_SESSION["cantidadesSeleccionadas"][$producto];
                $total += $_SESSION["cantidadesSeleccionadas"][$producto] * floatval($precio);
            } else {
                //si no lo son
                $mensaje = "No se han podido añadir al carrito los siguientes items: " . $producto . ". ";
                unset($_SESSION['cantidadesSeleccionadas']);
            }
        }
        $mensaje .= "El precio total es: $total esmeraldas.";
    }


    //realizamos la compra y actualizamos el carrito
    if (isset($_POST["comprar"])) {
        //Volvemos a definir que los productos seleccionados son un array vacío
        //por si han sido modificados
        $productosSeleccionados = [];
        //Consultamos el stock por si ha cambiado mientras el cliente elegía los productos
        $stock = unserialize(data: file_get_contents(RUTA_STOCK_FRED));
        $realizarCompra = true;
        $carritoVacio = true;

        foreach ($stock as $producto => $cantidad) {
            //Si alguna de las cantidades seleccionadas no son válidas
            //la compra no puede realizarse y se da por hecho que el carrito no está vacío
            if ($cantidad < $_SESSION["cantidadesSeleccionadas"][$producto] || $_SESSION["cantidadesSeleccionadas"][$producto] < 0) {
                $realizarCompra = false;
                $carritoVacio = false;
                //Si tan solo una de las cantidades seleccionadas no son 0
                //es porque el carrito no está vacío
            }elseif($_SESSION["cantidadesSeleccionadas"][$producto] !== 0){
                $carritoVacio = false;
            }
        }
        //Si está vacío no se realiza la compra
        if($carritoVacio){
            $realizarCompra = false;
        }

        //Si se realiza hacemos que el contador sume uno porq es una compra válida más
        if($realizarCompra){
            (int)$_SESSION["cont"] += 1;
            foreach ($stock as $producto => $cantidad) {
                //Almacenamos la compra en el fichero
                almacenaCompra($productosSeleccionados, $_SESSION["cont"]);
                $productosSeleccionados[$producto] = $_SESSION["cantidadesSeleccionadas"][$producto];
                //restamos el stock
                $stock[$producto] = $stock[$producto] - $_SESSION["cantidadesSeleccionadas"][$producto];
                $mensaje = "El pedido se ha realizado correctamente. Puede seguir comprando.";
            }


        //mostramos los mensajes de error
    }else if($carritoVacio){
        $mensaje = "No ha introducido nada en el carrito";
    }else{
        $mensaje = "No dispongo del stock necesario para completar su compra.";
    }

    //Actualizamos el fichero con el stock de helados
    file_put_contents(RUTA_STOCK_FRED, serialize($stock));


    // Limpiamos las cantidades seleccionadas después de la compra
    unset($_SESSION['cantidadesSeleccionadas']);

}

    ?>

    <!-- Por la razón que sea no se me actualizaba el stock en el html
    pero si en el .data y al cambiar el orden de dónde estaba colocado el formulario
    si que funciona -->
    <form action="carritoAvanzado.php" method="post">

        <?php
        foreach ($precios as $producto => $precio) {
            //Si existe cantidades Seleccionadas las recordamos en los inputs, si no las inicializamos a 0
            $cantidadEnSesion = isset($_SESSION['cantidadesSeleccionadas'][$producto]) ? $_SESSION['cantidadesSeleccionadas'][$producto] : 0;
            echo "<label>$producto </label>";
            echo " <input type='number' name='cantidad$producto' value='$cantidadEnSesion'></input> <br>";
            echo "<p> stock: $stock[$producto] Precio: $precio</p><br>";

        }

        foreach ($productosSeleccionados as $producto => $cantidad) {
            echo $producto . "-" . $cantidad . "<br>";
        }
        
        echo "<p>$mensaje</p>";

        ?>
        <input type="submit" name="actualizar" value="Actualizar">

        <input type="submit" name="comprar" value="Ejecutar comprar">

    </form>
</body>
</html>



<?php 
    //Solo en el caso de que se haya introducido un usuario lo almacenamos en el fichero de logs
    function almacenaCompra($productosSeleccionados, $contador_log){
        if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] !== ""){
            $stringProductosSeleccionados = json_encode($productosSeleccionados);
            if(file_exists(RUTA_LOGS)){
                $logs = unserialize(file_get_contents(RUTA_LOGS));
            }
                $logs[$_SESSION["usuario"] . "-" . $contador_log] = $stringProductosSeleccionados . "\n";    

                file_put_contents(RUTA_LOGS, serialize($logs));
        }
    }

?>