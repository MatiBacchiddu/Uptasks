<?php 

function usuario_autenticado()
{
    if(!revisar_usuario()){
        header('Location:login.php');
        exit();
    }
} // CIERRE USUARIO_AUTENTICADO

function revisar_usuario()
{
    return isset($_SESSION['nombre']);
} // CIERRE REVISAR_USUARIOS

// Este codigo va a Iniciar la sesión, revisa que el usuario este autenticado y si no lo esta, lo manda al login a que inicie sesión


session_start(); // arrancamos una sesion
usuario_autenticado();

?>