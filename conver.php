<?php
if(isset($_GET["euros"])){
    $euros = $_GET["euros"];
    $tipo = $_GET["tipo"];
    echo "<h1>Conversor de euros</h1>";
    if($tipo== "1"){
        $conver = $euros*1.325;
        echo "<p>$euros euros equivalen a $conver dolares</p>";
    }
    else if($tipo== "2"){
        $conver = $euros*0.927;
        echo "<p>$euros euros equivalen a $conver libras</p>";
    }
    else if($tipo== "3"){
        $conver = $euros*118.232;
        echo "<p>$euros euros equivalen a $conver yenes</p>";
    }
    else if($tipo== "4"){
        $conver = $euros*1.515;
        echo "<p>$euros euros equivalen a $conver francos</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br>
    <a href="conver.html">Volver atras</a>
</body>
</html>