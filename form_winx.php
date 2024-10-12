    <?php
    session_start();
    $bloom_pts = 0;
    $stella_pts = 0;
    $flora_pts = 0;
    $musa_pts = 0;
    $tecna_pts = 0;
    $personajes_pts = array(
        "Bloom" => $bloom_pts,
        "Stella" => $stella_pts,
        "Flora" => $flora_pts,
        "Musa" => $musa_pts,
        "Tecna" => $tecna_pts
    );
$check_nombre = false;
$check_triste = false;
$check_asignaturas = false;
$check_estacion = false;
$check_gusto = false;

$nombre_error = "";
$triste_error = "";
$asignaturas_error = "";
$estacion_error = "";
$gusto_error = "";

    if (isset($_POST["nombre"]) || isset($_POST["triste"]) || isset($_POST["asignaturas"]) || isset($_POST["estacion"])){
        if (!empty($_POST["nombre"])){
            $nombre = $_POST["nombre"];
            $check_nombre = true;
        }else{
            $nombre = "";
            $nombre_error = "Error: Por favor, introduce tu nombre.";
        }
        if(!empty($_POST["triste"])){
            $triste = $_POST["triste"];
            $check_triste = true;
        }else{
            $triste = "";
            $triste_error = "Error: Por favor, selecciona un campo.";
        }
        if(!empty($_POST["asignaturas"])){
            $asignaturas = $_POST["asignaturas"];
            $check_asignaturas = true;
        }else{
            $asignaturas = [];
            $asignaturas_error = "Error: Por favor, seleccione al menos un campo.";
        }
        if(!empty($_POST["estacion"])){
            $estacion = $_POST["estacion"];
            $check_estacion = true;
        }else{
            $estacion = "";
            $estacion_error =  "Error: Por favor, seleccione una opcion valida";
        }
        if(!empty($_POST["gusto"])){
            $gusto = $_POST["gusto"];
            $check_gusto = true;
        }else{
            $gusto = "1";
            $gusto_error = "Por favor seleccione una opcion valida. No hagas cosas raras con la consola";
        }
    $_SESSION["nombre"] = $nombre;
    $_SESSION["triste"] = $triste;
    $_SESSION["asignaturas"] = $asignaturas;
    $_SESSION["estacion"] = $estacion;
    $_SESSION["gusto"] = $gusto;

    if($check_nombre&&$check_triste&&$check_asignaturas&&$check_estacion&&$check_gusto){
        header("Location: conver.html");
        exit();
    }
    }else{
        //Esto y lo de abajo son lo mismo, pero no quiero que me ocupe 5 veces mas. Aun asi pues eso, demuestro que se lo que estoy haciendo
        if (isset($_SESSION["nombre"])) {
            $nombre = $_SESSION["nombre"];
        } else {
            $nombre = "";
        }
        $triste = $_SESSION["triste"] ?? "";
        $asignaturas = $_SESSION["asignaturas"] ?? [];
        $estacion = $_SESSION["estacion"] ?? "";
        $gusto = $_SESSION["gusto"] ?? "0";
    }
    if(isset($_POST["reset"])){
        session_destroy();
        $_SESSION = [];
        $nombre="";
        $triste ="";
        $asignaturas=[];
        $estacion="";
        $gusto = 1;
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            #triste{
                display: flex;
                flex-direction: row;
            }
            #triste div{
                border: 2px solid pink;
                border-radius: 20px;
                width: 200px;
                margin: 10px;
                padding: 5px;
            }
            #asig{
                display: flex;
                flex-direction: row;
            }
            #asig div{
                border: 2px solid pink;
                border-radius: 20px;
                width: 200px;
                margin: 10px;
                padding: 5px;
            }
            .error{
                color: red;
            }
        </style>
    </head>
    <body>
        <h1>TEST DE WINX CLUB</h1>
        <h3>¿Quieres saber que personaje de las winx eres? Si la respuesta es si, rellena el formulario</h3>
        <br>
        <form action="form_winx.php" method="post">
            <!-- Input nombre -->
            <label for="nombre">¿Como te llamas? (Obligatorio)</label>
            <input type="text" name="nombre" value="<?php echo $nombre;?>"><br><br>
            <?php
        if (!$check_nombre) {
            echo "<div class='error'>$nombre_error</div>";
        }
        ?>
            <!--Inputs radio-->
            <br>
            <label>Cuando estas triste, ¿que prefieres hacer? (Selecciona una)</label><br>
            <div id="triste">
            <div>
                <label>Salir con amigas</label>
                <input type="radio" name="triste" value="bloom" 
                <?php if ($triste == "bloom") echo 'checked';?>>
            </div>

            <div>
                <label>Ir de compras</label>
                <input type="radio" name="triste" value="stella"
                <?php if ($triste == "stella") echo 'checked';?>>
            </div>

            <div>
                <label>Dar un paseo por el campo</label>
                <input type="radio" name="triste" value="flora"
                <?php if ($triste == "flora") echo 'checked';?>>
            </div>

            <div>
                <label>Escuchar musica</label>
                <input type="radio" name="triste" value="musa"
                <?php if ($triste == "musa") echo 'checked';?>>
            </div>

            <div>
                <label>Jugar videojuegos</label>
                <input type="radio" name="triste" value="tecna"
                <?php if ($triste == "tecna") echo 'checked';?>>
            </div>
            </div>
            <?php
        if (!$check_triste) {
            echo "<div class='error'>$triste_error</div>";
        }
        ?>
            <br><br>
            <!-- Inputs checkbox -->
            <label>¿Que asignaturas te gustan en el instituto? (Selecciona al menos una)</label><br>
            <div id="asig">
            
            <div>
                <input type="checkbox" name="asignaturas[]" value="tecna"
                <?php if (in_array("tecna", $asignaturas)) echo 'checked'; ?>>
                <label>Tecnologia</label>
            </div>
            
            <div>
                <input type="checkbox" name="asignaturas[]" value="stella"
                <?php if (in_array("stella", $asignaturas)) echo 'checked'; ?>>
                <label>Lengua</label>
            </div>
            
            <div>
                <input type="checkbox" name="asignaturas[]" value="flora"
                <?php if (in_array("flora", $asignaturas)) echo 'checked'; ?>>
                <label>Biologia</label>
            </div>
            
            <div>
                <input type="checkbox" name="asignaturas[]" value="musa"
                <?php if (in_array("musa", $asignaturas)) echo 'checked'; ?>>
                <label>Musica</label>
            </div>
            
            <div>
                <input type="checkbox" name="asignaturas[]" value="bloom">
                <?php if (in_array("bloom", $asignaturas)) echo 'checked'; ?>
                <label>Educacion Fisica</label>
            </div>
            </div>
            <?php
        if (!$check_asignaturas) {
            echo "<div class='error'>$asignaturas_error</div>";
        }
        ?>
            <br>
            <!-- Input selects -->
            <label>¿Cual es tu estacion de año favorita?</label>
            <select name="estacion">
                <option value="" <?php if ($estacion == "") echo 'selected'; ?>>Selecciona una estación</option>
                <option value="tecna" <?php if ($estacion == "tecna") echo 'selected'; ?>>Cualquiera</option>
                <option value="flora" <?php if ($estacion == "flora") echo 'selected'; ?>>Primavera</option>
                <option value="stella" <?php if ($estacion == "stella") echo 'selected'; ?>>Verano</option>
                <option value="bloom" <?php if ($estacion == "bloom") echo 'selected'; ?>>Otoño</option>
                <option value="musa" <?php if ($estacion == "musa") echo 'selected'; ?>>Invierno</option>
            </select>
            <?php
            if (!$check_estacion) {
                echo "<div class='error'>$estacion_error</div>";
            }
            ?>
            <br><br>
            <!-- Input range -->
            <label for="range_val">Te sientes atraida por: (En el medio es ambas)</label><br>
            <label>Chicas</label><input type="range" name="gusto" min="0" max="2" value="<?php echo $gusto;?>"><label>Chicos</label>
            <?php
            if (!$check_gusto) {
                echo "<div class='error'>$gusto_error</div>";
            }
            ?>
            <br><br>
            <button type="submit">Enviar</button>
        </form>
        <br>
        <form action="form_winx.php" method="post">
        <button type="submit" name="reset">Borrar</button>
        </form>
    </body>
    </html>