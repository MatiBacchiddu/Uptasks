<?php 

session_start();
include 'inc/templates/header.php';  
include 'inc/funciones/funciones.php';


// echo '<pre>';
// var_dump($_SESSION); MUESTRA LOS DATOS DE LA SESION
// echo '</pre>';

// echo '<hr>';
// var_dump($_GET); MUESTRA EL PARAMETRO QUE MANDAMOS COMO cerrar_sesion=true

if(isset($_GET['cerrar_sesion'])) {
    $_SESSION = array();
}

var_dump($_SESSION);

?>
<body class="login">
    
    <div class="contenedor-formulario">
        <h1>UpTask</h1>
        <form id="formulario" class="caja-login" method="post">
            <div class="campo">
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            </div>
            <div class="campo">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="campo enviar">
                <input type="hidden" id="tipo" value="login">
                <input type="submit" class="boton" value="Iniciar Sesión">
            </div>

            <div class="campo">
                <a href="crear-cuenta.php">Crea una cuenta nueva</a>
            </div>
        </form>
    </div>

<?php 

include 'inc/templates/footer.php';  

?>