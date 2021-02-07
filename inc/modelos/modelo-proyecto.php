<?php 

$accion = $_POST['accion'];
$proyecto = $_POST['proyecto'];

if($accion == 'crear') {

    include '../funciones/conexion.php';

    try {
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre) VALUES (?)");
        $stmt->bind_param('s', $proyecto);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            $respuesta = array(
                'respuesta' => 'correcto',
                "id_proyecto" => $stmt->insert_id,
                'tipo' => $accion,
                'proyecto' => $proyecto
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

        $stmt->close();
        $conn->close();


    } catch (Exception $e) {
        //tomar el error
        $respuesta = array(
            'msg' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}


// echo json_encode($_POST);

?>