<?php
if(isset($_GET["str_guardar"])){
    $str_guardar = $_GET["str_guardar"];
}else{
    $str_guardar="";
}

if(isset($_GET["str_pasar"]) && $_GET["str_pasar"] !== ""){
    if($str_guardar !== ""){
        $str_guardar .= "/";
    }
    $str_guardar .= $_GET["str_pasar"];
}

$arr = explode("/",$str_guardar);
print '<div>';
foreach ($arr as $parrafo) {
    print '<p>' . $parrafo . '</p>';
}
print '</div>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="texto.php" method="get">
    <label for="mensaje">Añade texto!: </label>
    <input type="text" name="str_pasar"><br>
    <input type="hidden" name="str_guardar" value="<?php echo $str_guardar?>">
    <button>Dale</button>
    </form>

</body>
</html>