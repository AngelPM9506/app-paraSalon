<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
/**Captar el la ultima parte de imprecion por foreach en citas admin**/
function esUltimo(string $actual, string $ultimo) : bool{
    if ($actual !== $ultimo) {
        return true;
    }else {
        return false;
    }
}
/**Funcion que revisa que el usuario este autenticado**/
function isAuth():void{
    if (!isset($_SESSION['login']) || isset($_SESSION['admin'])) {
        header('Location: /');
    }
}

/**Funcion que revisa que el usuario este autenticado y sea admin */
function isAdmin():void{
    if (!isset($_SESSION['admin']) || !isset($_SESSION['login'])) {
        header('Location: /');
    }
}