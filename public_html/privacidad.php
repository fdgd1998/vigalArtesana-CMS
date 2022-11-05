<?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_site_settings.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";
    $site_settings = getSiteSettings();
    $conn = new DatabaseConnection(); // Opening database connection.

    if ($site_settings[11]["value_info"] == "true" || ($site_settings[11]["value_info"] == "true" && !isset($_SESSION["loggedin"]))) { 
        require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_503_header.php";
        set_503_header();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($site_settings[11]["value_info"] == "false"): ?>
    <title>Política de privacidad | <?=$site_settings[2]["value_info"]?></title>
    <meta name="description" content="Política de privacidad.">
    <meta name="robots" content="index, follow">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5GCTKSYQEQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5GCTKSYQEQ');
    </script>
    <?php else: ?>
    <title>Página en mantenimiento | <?=$site_settings[2]["value_info"]?></title>
    <?php endif; ?>
    <link rel="canonical" href="<?=GetUri();?>">
    <link rel="icon" href="<?=GetBaseUri()?>/includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />    
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
</head>

<body>
    <?php
    if ($site_settings[11]["value_info"] == "true" && !isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        exit();
    }
    if ($site_settings[11]["value_info"] == "true" && isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
    }
    include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
    ?>
    <div id="main">
        <div class="container content">
            <h1 class="title">Política de privacidad</h1>
            <p>De acuerdo con lo establecido en el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016, relativo a la protección de las personas físicas en lo que respecta al tratamiento de datos personales y a la libre circulación de estos datos (RGPD) y LO 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD),  les informamos sobre el tratamiento de los datos personales que nos facilitan a través de esta Web </p>
            <h3 class="title">¿Quién es el responsable del tratamiento de sus datos personales?</h3>
            <p>Razón Social: Victoria Eugenia Díaz Gálvez</p>
            <p>Dirección: <?=$site_settings[1]["value_info"]?></p>
            <p>Email de contacto: <?=$site_settings[3]["value_info"]?></p>
            <p>Teléfono: <?=$site_settings[0]["value_info"]?></p>
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
            include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
        ?>
    </div>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>