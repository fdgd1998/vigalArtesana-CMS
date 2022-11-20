<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/dashboard/scripts/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));

    $about_text = $site_settings[9]["value_info"];
?>
<div class="container content">
    <h1 class="title">Información del software</h1>
    <p class="title-description">ViGal Artesana CMS, versión: <strong><?=$site_settings[15]["value_info"]?></strong>. Desarrollado por Francisco Gálvez.</p>
    <p>Registro de cambios:</p>
    <p><strong>Versión 2.0.1 (20/11/2022)</strong></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li>Nuevos iconos de interfaz de usuarios.</li>
        <li>Arreglos del código fuente.</li>
    </ul>
    <p><strong>Versión 2.0 (20/11/2022)</strong></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li>Interfaz de usuario mejorada.</li>
        <li>Añadido sistema de SEO con generación dinámica de sitemap.xml.</li>
        <li>Añadido editor de texto para algunos ficheros.</li>
        <li>Añadido sistema de logs.</li>
        <li>Librerías de terceros actualizadas.</li>
        <li>Sistema de árbol de directorios de galería optimizado.</li>
        <li>Atributos SEO de contenido mejorados.</li>
        <li>Añadido sistema de gestión de usuarios y permisos.</li>
        <li>Aladido página de perfil de usuario.</li>
        <li>Añadida recuperación de contraseña vía SSPR.</li>
        <li>Modo de mantenimiento optimizado y mejorado.</li>
        <li>Metadatos de páginas optimizados para SEO.</li>
        <li>Añadidas descripciones de categorías de la galería.</li>
        <li>Opciones de configuración de datos básicos del sitio web mejoradas.</li>
        <li>Nuevos estilos CSS.</li>
        <li>Añadido sistema compresión de imágenes.</li>
    </ul>
    <p><strong>Versión 1.0 (30/11/2021)</strong></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li>Versión inicial.</li>
        <li>Añadido sistema de galería y categorías.</li>
        <li>Añadido sistema de gestión de servicios.</li>
        <li>Añadido modo de mantenimiento.</li>
        <li>Añadidas opciones de configuración de datos básicos del sitio web.</li>
        <li>Añadida página de contacto.</li>
        <li>Añadido página sobre nosotros.</li>
        <li>Añadida página de aviso legal.</li>
        <li>Añadida página de política de privacidad.</li>
    </ul>
</div>