<?php

$accion = $_POST['accion'];
$password = $_POST['password'];
$usuario = $_POST['usuario'];

if($accion == 'crear') {
    // codigo para crear los administradores

    // hashear password
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

    // importar conexion
    include '../funciones/conexion.php';

    try {
        // realizar la consulta
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $usuario, $hash_password); // 'ss' se debe a que estamos insertando strings, si fuesen numeros seria 'is'
        $stmt->execute(); // ejecuta la consulta

        if($stmt->affected_rows > 0) { // si hubo columnas afectadas, es decir, se les hizo algo, entonces envia la $respuesta
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_insertado' => $stmt->insert_id,
                'tipo' => $accion
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // tomar la excepcion
        $respuesta = array(
            'pass' => $e->getMessage()
        );

    }

    echo json_encode($respuesta);


    // echo json_encode($respuesta);
}

// ############################################################  LOGEADO  #########################################################

if($accion === 'login') {
      // importar conexion
      include '../funciones/conexion.php';

      try {
        // seleccionar el admin de la db
        $stmt = $conn->prepare("SELECT usuario, id, password FROM usuarios WHERE usuario = ? "); // estas consultas son mas seguras al poner un ?
        $stmt->bind_param('s', $usuario); // en este caso solo se agrega una 's'  ya que es solo un dato y es de tipo string, en el caso de que sean 2 datos y uno de ellos es un integer tendria que ser 'is'
        $stmt->execute();
        // Loguear el usuario
        $stmt->bind_result($nombre_usuario, $id_usuario, $pass_usuario); // retorna el usuario, id y password del usuario que escribamos
        $stmt->fetch();


        // si el usuario existe: 
       if($nombre_usuario) {

            //el usuario existe, verificar password
            if(password_verify($password, $pass_usuario)) { // toma 2 params, el password que viene de la base de datos y el password hashed
                
                // ya que el usuario y psswd son correctos, iniciamos la sesión
                session_start();
                $_SESSION['nombre'] = $usuario;
                $_SESSION['id'] = $id_usuario;
                $_SESSION['login'] = true;

                // Login correcto
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'resultado' => 'Login correcto',
                    'nombre' => $nombre_usuario,
                    'tipo' => $accion
                );
            } else {
                // incorrecto
                $respuesta = array(
                    'resultado' => 'password incorrecto'
                );
            }
            // $respuesta = array(
            //     'respuesta' => 'correcto',
            //     'nombre' => $nombre_usuario,
            //     'id'  => $id_usuario,
            //     'pass' => $pass_usuario
            // );
       } else {
           $respuesta = array(
               'error' => 'El usuario no fue encontrado'
           );
       }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        // tomar la excepcion
        $respuesta = array(
            'pass' => $e->getMessage()
        );
      }

      echo json_encode($respuesta);
}

?>