<?php
if (isset($_POST['accion'])){
    if($_POST['accion'] == 'editar') {
        //echo json_encode($_POST);
    
        require_once('../funciones/bd.php');
    
        // Validar las entradas
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $primer_ap = filter_var($_POST['primer_ap'], FILTER_SANITIZE_STRING);
        $segundo_ap = filter_var($_POST['segundo_ap'], FILTER_SANITIZE_STRING);
        $edad = filter_var($_POST['edad'], FILTER_SANITIZE_NUMBER_INT);
        $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    
        try{
            $stmt = $conn->prepare("UPDATE contacto SET nombre = ?, primer_ap = ?, segundo_ap = ?, edad = ?, direccion = ? WHERE id = ?");
            $stmt->bind_param("sssisi", $nombre,  $primer_ap,  $segundo_ap, $edad, $direccion, $id);
            $stmt->execute();
            if($stmt->affected_rows == 1){
                $respuesta = array(
                        'respuesta' => 'correcto'
                );
            } else {
                $respuesta = array(
                        'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch(Exception $e){
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
        echo json_encode($respuesta);
    }
}


