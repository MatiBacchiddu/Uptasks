<?php 

function obtenerPaginaActual()
{
    $archivo = basename($_SERVER['PHP_SELF']); // OBTENEMOS EL ARCHIVO ACTUAL
    $pagina = str_replace(".php", "", $archivo); // Se reemplaza el .php por nada y luego el nombre del archivo nos quedaria Index.php => Index
    // echo $pagina;
    return $pagina;
}


?>