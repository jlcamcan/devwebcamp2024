<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) :bool{
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path)  ? true:false;
}

//Función que comprueba si un usuario está autenticado
function is_auth():bool{
    if (!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}
//Función que comprueba si un usuario es administrador
function es_admin():bool{
    if (!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

//Función para añadir animaciones aleatorias
function aos_animacion():void{
    $efectos = ['fade-up', 'fade-down', 'fade-right', 'fade-left', 'flip-right', 'flip-left','zoom-in-up','zoom-out-down'];
    $efecto = array_rand($efectos, 1);
    echo ' data-aos="' . ($efectos[$efecto] . '" ');
}





