<?php
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/connection.php';
    $GLOBALS["site_settings"] = array();
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        print("No se ha podido conectar a la base de datos");
        exit();
    } else {
        $sql = "select value_info from company_info";
        $res = $conn->query($sql);
        while ($rows = $res->fetch_assoc()) {
            array_push($GLOBALS["site_settings"], $rows['value_info']);
        }
    }
    $GLOBALS["site_settings"][4] = json_decode($GLOBALS["site_settings"][4], true);
    
    $conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de privacidad - ViGal Artesana</title>
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link href="http://fonts.cdnfonts.com/css/gotham" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <div id="main">
        <?php
            include './includes/header.php';
        ?>
        <div class="container content">
            <h1 class="title">Política de privacidad</h1>
            <p>De acuerdo con lo establecido en el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, relativo a la protección de las personas físicas en lo que respecta al tratamiento de datos personales y a la libre circulación de estos datos (RGPD) y LO 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD),  les informamos sobre el tratamiento de los datos personales que nos facilitan a través de esta Web </p>
            <h3 class="title">¿Quién es el responsable del tratamiento de sus datos personales?</h3>
            <p>Razón Social: Victoria Eugenia Díaz Gálvez</p>
            <p>NIF: 77472123G</p>
            <p>Dirección: Diseminado Vado, 154, 29749 Almayate, Málaga</p>
            <p>Email de contacto: contacto@vigalartesana.es</p>
            <p>Tlf: +34602036830</p>
            <h3 class="title">¿Con qué finalidad trataremos sus datos personales?</h3>
            <p>Como Usuario de la Web: Sus datos serán utilizados para dar respuestas  solicitudes de información, comentarios o sugerencias, a través del apartado de contacto o de las direcciones de correo que aparezcan en nuestra página y mantener la comunicación con el interesado.</p>
            <p>Como seguidor en RRSS: Los datos que hayas facilitado a la red social serán usados para mantener un seguimiento mutuo de nuestras cuentas y poder contactar contigo siempre a través de la red social elegida. </p>
            <h3 class="title">¿Cuál es la legitimación para el tratamiento de sus datos personales?</h3>
            <p>Como Usuario de la Web: El consentimiento del interesado que nos dirige su consulta o solicitud de información o, en caso de solicitar un presupuesto de nuestros servicios, la aplicación de medidas precontractuales a petición suya. La comunicación de sus datos es necesaria para poder atender sus consultas y solicitudes, conforme a los Art. 6.1.a) y Art.6.1. b) del RGPD respectivamente.</p>
            <p>Como seguidor en RRSS: Consentimiento del interesado, conforme al Art. 6.1.a) del RGPD.</p>
            <h3 class="title">¿Por cuánto tiempo conservaremos sus datos personales?</h3>
            <p>Como Usuario de la Web: Conservados hasta cumplir su finalidad o hasta que nos revoque el consentimiento prestado.</p>
            <p>Como seguidor en RRSS: Serán conservados hasta que nos revoque el consentimiento prestado o dejes de seguirnos o marques ya no me gusta.</p>
            <h3 class="title">¿Cederemos sus datos personales?</h3>
            <p>Como Usuario de la Web: Sus datos personales no serán cedidos salvo por obligación legal. No obstante, los datos tratados a través de esta página web serán accesibles por nuestro proveedor de hosting.</p>
            <p>Como seguidor en RRSS: Sus datos personales no serán cedidos salvo por obligación legal.</p>
            <h3 class="title">¿Qué derechos tiene cuando nos facilita sus datos personales?</h3>
            <p>Como interesado le asisten los derechos que indicamos a continuación, pero tenga en cuenta que en el caso de las redes sociales nosotros accedemos a los datos personales que aparecen en su perfil como consecuencia del seguimiento mutuo realizado a nuestras cuentas de Facebook o Instagram exclusivamente, por lo tanto, el ejercicio de los derechos sobre sus datos personales entendemos que debe realizarlos a la propia red social, a pesar de lo cual le informamos de cuales son</p>
            <ul style="list-style-type: disc; padding-left:40px;">
                <li>Derecho de Acceso: Usted tiene derecho a saber si se están tratando sus datos y a recibir esa información por escrito a través del medio solicitado. </li>
                <li>Derecho de Rectificación: Usted tiene derecho a solicitar la rectificación de sus datos si estos fuesen inexactos o incompletos.</li>
            </ul>
            <p>Usted tiene derecho a solicitar la supresión de sus datos, sin embargo, deberá tener en cuenta que el derecho de supresión queda limitado cuando exista obligación legal de retención o bloqueo de sus datos.</p>
            <p>En determinadas circunstancias, los interesados podrán solicitar la limitación del tratamiento de sus datos, en cuyo caso únicamente los conservaremos para el ejercicio o la defensa de reclamaciones, la protección de terceros o por razones de interés público importante.</p>
            <p>En determinadas circunstancias y por motivos relacionados con su situación particular, Usted podrá oponerse al tratamiento de sus datos. El responsable dejará de tratar los datos, salvo por motivos legítimos imperiosos, o el ejercicio o la defensa de posibles reclamaciones.</p>
            <p>Cuando el tratamiento de sus datos esté basado en el consentimiento o sea necesario para la ejecución de un contrato o precontrato y se efectúe por medios automatizados, Usted tendrá derecho a la portabilidad de sus datos, es decir, a que se le entreguen en formato estructurado, de uso común y lectura mecánica, incluso a remitírselos a un nuevo responsable.</p>
            <p>Para ejercitar cualquiera de los derechos indicados, puede dirigirse por escrito a la atención de Victoria Eugenia Díaz Gálvez en su dirección postal o mediante correo electrónico dirigido a contacto@vigalartesana.es. En todo caso, deberá acompañar a la solicitud copia de su DNI para acreditar su identidad.</p>
            <p>Cualquier interesado podrá presentar una reclamación ante la Autoridad de Control competente en materia de Protección de Datos, especialmente cuando no haya obtenido satisfacción en el ejercicio de sus derechos y la forma de ponerse en contacto con ella sería dirigir un escrito a Agencia Española de Protección de Datos Personales en C/Jorge Juan n.º 6, 28001 Madrid o a través de su sede electrónica en www.agpd.es </p>
        </div>
        <?php
            include './includes/footer.php';
        ?>
    </div>
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/js/header.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>