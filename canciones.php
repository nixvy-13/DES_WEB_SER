<?php
if((isset($_GET["cancion"]) && !empty($_GET["cancion"]))&&(isset($_GET["opcion"]))) {
    $cancion = $_GET["cancion"];
    $opcion = $_GET["opcion"];
    $genero = $_GET["genero"];
    echo "<ul>";
    echo "<li>Texto de busqueda: $cancion</li>";
    echo "<li>Buscar en: $opcion</li>";
    echo "<li>Genero: $genero</li>";
    echo "</ul>";
    echo "<a href='canciones.html'>Volver</a>";
}else{
    echo "<h1>Introduce los datos correctamente</h1>";
    echo "<a href='canciones.html'>Volver</a>";
}
?>