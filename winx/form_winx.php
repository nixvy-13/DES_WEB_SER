    <?php
    session_start();
if (!isset($_SESSION['personajes_pts'])) {
    $_SESSION['personajes_pts'] = array(
        "Bloom" => 0,
        "Stella" => 0,
        "Flora" => 0,
        "Musa" => 0,
        "Tecna" => 0
    );
}
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
    if(isset($_POST['confirmar'])){
        $resultado_final = true;
    }
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
        if(($_POST["gusto"])>-1&&($_POST["gusto"])<3){
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
        $muestra_resumen = true;
        // Incrementar los puntajes según la respuesta del usuario
    if($triste == 'bloom') {
        $_SESSION['personajes_pts']['Bloom']++;
    } else if($triste == 'stella') {
        $_SESSION['personajes_pts']['Stella']++;
    } else if($triste == 'flora') {
        $_SESSION['personajes_pts']['Flora']++;
    } else if($triste == 'musa') {
        $_SESSION['personajes_pts']['Musa']++;
    } else {
        $_SESSION['personajes_pts']['Tecna']++;
    }

    // Asignaturas
    if(in_array('bloom', $asignaturas)) {
        $_SESSION['personajes_pts']['Bloom']++;
    }
    if(in_array('stella', $asignaturas)) {
        $_SESSION['personajes_pts']['Stella']++;
    }
    if(in_array('flora', $asignaturas)) {
        $_SESSION['personajes_pts']['Flora']++;
    }
    if(in_array('musa', $asignaturas)) {
        $_SESSION['personajes_pts']['Musa']++;
    }
    if(in_array('tecna', $asignaturas)) {
        $_SESSION['personajes_pts']['Tecna']++;
    }

    // Estación
    if($estacion == 'bloom') {
        $_SESSION['personajes_pts']['Bloom']++;
    } else if($estacion == 'stella') {
        $_SESSION['personajes_pts']['Stella']++;
    } else if($estacion == 'flora') {
        $_SESSION['personajes_pts']['Flora']++;
    } else if($estacion == 'musa') {
        $_SESSION['personajes_pts']['Musa']++;
    } else {
        $_SESSION['personajes_pts']['Tecna']++;
    }

    // Gusto
    if($gusto == 2) {
        $_SESSION['personajes_pts']['Bloom']++;
        $_SESSION['personajes_pts']['Stella']++;
    } else if($gusto == 0) {
        $_SESSION['personajes_pts']['Musa']++;
        $_SESSION['personajes_pts']['Tecna']++;
    } else {
        $_SESSION['personajes_pts']['Flora']++;
    }
   
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
        $gusto = $_SESSION["gusto"] ?? "1";
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
    function datos_servidor(){
    echo '<h4>Datos del Servidor</h4>';
    echo '<ul>';
    echo '<li>Protocolo: ' .$_SERVER['SERVER_PROTOCOL'] . '</li>';
    echo '<li>Nombre del Host: ' . $_SERVER['HTTP_HOST'] . '</li>';
    echo '<li>Puerto: ' .$_SERVER['SERVER_PORT'] . '</li>';
    echo '</ul>';
    echo '<h4>Cabeceras HTTP</h4>';
    $headers = apache_request_headers();
    echo '<ul>';
    if (isset($headers['User-Agent'])) {
        echo '<li><strong>User-Agent:</strong> ' . $headers['User-Agent'] . '</li>';
    }
    if (isset($headers['Accept-Language'])) {
        echo '<li><strong>Accept-Language:</strong> ' .$headers['Accept-Language'] . '</li>';
    }
    echo '</ul>';
    }
    function mostrarForm($nombre, $triste, $asignaturas, $estacion, $gusto, $check_nombre, $check_triste, $check_asignaturas, $check_estacion, $check_gusto, $nombre_error, $triste_error, $asignaturas_error, $estacion_error, $gusto_error) {
        return '
        <h1>TEST DE WINX CLUB</h1>
        <h3>¿Quieres saber que personaje de las winx eres? Si la respuesta es si, rellena el formulario</h3>
        <br>
        <form action="form_winx.php" method="post">
            <!-- Input nombre -->
            ' . ($check_nombre ? '' : "<div class='error'>$nombre_error</div>") . '
            <label for="nombre">¿Como te llamas? (Obligatorio)</label>
            <input type="text" name="nombre" value="' . $nombre . '"><br><br>
            <br>
            <!--Inputs radio-->
            ' . ($check_triste ? '' : "<div class='error'>$triste_error</div>") . '
            <label>Cuando estas triste, ¿que prefieres hacer? (Selecciona una)</label><br>
            <div id="triste">
                <div>
                    <label>Salir con amigas</label>
                    <input type="radio" name="triste" value="bloom" ' . ($triste == "bloom" ? 'checked' : '') . '>
                </div>
                <div>
                    <label>Ir de compras</label>
                    <input type="radio" name="triste" value="stella" ' . ($triste == "stella" ? 'checked' : '') . '>
                </div>
                <div>
                    <label>Dar un paseo por el campo</label>
                    <input type="radio" name="triste" value="flora" ' . ($triste == "flora" ? 'checked' : '') . '>
                </div>
                <div>
                    <label>Escuchar musica</label>
                    <input type="radio" name="triste" value="musa" ' . ($triste == "musa" ? 'checked' : '') . '>
                </div>
                <div>
                    <label>Jugar videojuegos</label>
                    <input type="radio" name="triste" value="tecna" ' . ($triste == "tecna" ? 'checked' : '') . '>
                </div>
            </div>
            <br><br>
            <!-- Inputs checkbox -->
            ' . ($check_asignaturas ? '' : "<div class='error'>$asignaturas_error</div>") . '
            <label>¿Que asignaturas te gustan en el instituto? (Selecciona al menos una)</label><br>
            <div id="asig">
                <div>
                    <input type="checkbox" name="asignaturas[]" value="tecna" ' . (in_array("tecna", $asignaturas) ? 'checked' : '') . '>
                    <label>Tecnologia</label>
                </div>
                <div>
                    <input type="checkbox" name="asignaturas[]" value="stella" ' . (in_array("stella", $asignaturas) ? 'checked' : '') . '>
                    <label>Lengua</label>
                </div>
                <div>
                    <input type="checkbox" name="asignaturas[]" value="flora" ' . (in_array("flora", $asignaturas) ? 'checked' : '') . '>
                    <label>Biologia</label>
                </div>
                <div>
                    <input type="checkbox" name="asignaturas[]" value="musa" ' . (in_array("musa", $asignaturas) ? 'checked' : '') . '>
                    <label>Musica</label>
                </div>
                <div>
                    <input type="checkbox" name="asignaturas[]" value="bloom" ' . (in_array("bloom", $asignaturas) ? 'checked' : '') . '>
                    <label>Educacion Fisica</label>
                </div>
            </div>
            <br>
            <!-- Input selects -->
            ' . ($check_estacion ? '' : "<div class='error'>$estacion_error</div>") . '
            <label>¿Cual es tu estacion de año favorita?</label>
            <select name="estacion">
                <option value="" ' . ($estacion == "" ? 'selected' : '') . '>Selecciona una estación</option>
                <option value="tecna" ' . ($estacion == "tecna" ? 'selected' : '') . '>Cualquiera</option>
                <option value="flora" ' . ($estacion == "flora" ? 'selected' : '') . '>Primavera</option>
                <option value="stella" ' . ($estacion == "stella" ? 'selected' : '') . '>Verano</option>
                <option value="bloom" ' . ($estacion == "bloom" ? 'selected' : '') . '>Otoño</option>
                <option value="musa" ' . ($estacion == "musa" ? 'selected' : '') . '>Invierno</option>
            </select>
            <br><br>
            <!-- Input range -->
            ' . ($check_gusto ? '' : "<div class='error'>$gusto_error</div>") . '
            <label for="range_val">Te sientes atraida por: (En el medio es ambas)</label><br>
            <label>Chicas</label>
            <input type="range" name="gusto" min="0" max="2" value="' . $gusto . '">
            <label>Chicos</label>
            <br><br>
            <button type="submit">Enviar</button>
        </form>
        <br>
        <form action="form_winx.php" method="post">
            <button type="submit" name="reset">Borrar</button>
        </form>
        ';
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
            img{
                width: 300px;
                height: 800px;
                object-fit: cover;
            }
        </style>
    </head>
    <body>
    <?php 
    // Mostrar formulario o resumen
    if (isset($muestra_resumen) && $muestra_resumen) {
        // Resumen de los datos procesados
        echo "<h2>Resumen de tus datos</h2>";
        echo "<p>Nombre: " . $nombre. "</p>";
        echo "<p>Cuando estás triste prefieres: " . $triste . "</p>";
        echo "<p>Asignaturas elegidas: " . implode(", ", $asignaturas) . "</p>";
        echo "<p>Estación favorita: " . $estacion . "</p>";
        echo "<p>Te sientes atraída por: " . $gusto . "</p>";
        echo '<form action="form_winx.php" method="post">
                <button type="submit" name="confirmar">Confirmar Datos</button>
              </form>';
    }
    else if (isset($resultado_final) && $resultado_final) {
        // Mostrar mensaje de agradecimiento si se confirma
        $max_pts = max($_SESSION['personajes_pts']);
        $personaje_ganador = array_search($max_pts, $_SESSION['personajes_pts']);
        echo "$nombre"." eres "."$personaje_ganador". "!!!";
        if($personaje_ganador=='Bloom'){
            echo "<img src='bloom.jpg'>";
        }else if($personaje_ganador=='Stella'){
            echo "<img src='stella.jpg'>";
        }else if($personaje_ganador=='Flora'){
            echo "<img src='flora.jpg'>";
        }else if($personaje_ganador=='Musa'){
            echo "<img src='musa.jpg'>";
        }else if($personaje_ganador=='Tecna'){
            echo "<img src='tecna.jpg'>";
        }
        echo "<h2>¡Gracias por participar!</h2>";
        echo '<form action="form_winx.php" method="post">
            <button type="submit" name="reset">Volver al formulario</button>
          </form>';
    } else {
        // Mostrar el formulario
        echo datos_servidor();
        echo mostrarForm($nombre, $triste, $asignaturas, $estacion, $gusto, $check_nombre, $check_triste, $check_asignaturas, $check_estacion, $check_gusto, $nombre_error, $triste_error, $asignaturas_error, $estacion_error, $gusto_error);
    }
    ?>
    </body>
    </html>