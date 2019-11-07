<?php
if (isset($_POST['accion'])){
     if($_POST['accion'] == 'crear'){
          // creara un nuevo registro en la base de datos
      
          require_once('../funciones/bd.php');
      
          // Validar las entradas 
          $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
          $primer_ap = filter_var($_POST['primer_ap'], FILTER_SANITIZE_STRING);
          $segundo_ap = filter_var($_POST['segundo_ap'], FILTER_SANITIZE_STRING);
          $edad = filter_var($_POST['edad'], FILTER_SANITIZE_NUMBER_INT);
          $direccion = filter_var($_POST['direccion'], FILTER_SANITIZE_STRING);
      
          try {
              $stmt = $conn->prepare("INSERT INTO contacto (nombre, primer_ap, segundo_ap, edad, direccion) VALUES (?,?,?,?,?)");
              $stmt->bind_param("sssis", $nombre, $primer_ap, $segundo_ap, $edad, $direccion);
              $stmt->execute();
              if($stmt->affected_rows == 1) {
                  $respuesta = array(
                      'respuesta' => 'correcto',
                      'datos' => array(
                          'nombre' => $nombre,
                          'primer_ap' => $primer_ap,
                          'segundo_ap' => $segundo_ap,
                          'edad' => $edad,
                          'direccion'=> $direccion,
                          'id_insertado' => $stmt->insert_id
                          )
                      );
              }
              $stmt->close();
              $conn->close();
          } catch(Exception $e) {
              $respuesta = array(
                  'error' => $e->getMessage()
              );
          }
      
          echo json_encode($respuesta);
      }
}