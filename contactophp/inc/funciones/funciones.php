<?php
function obtenerContactos() {
    include 'bd.php';
    try{
        return $conn->query("SELECT id, nombre, primer_ap, segundo_ap, edad, direccion FROM contacto");
    } catch (Exception $e) {
        echo "Error!!" , $e->geMessage() . "<br>";
        return false;
    }
}

// Otiene un contacto toma un id

function obtenerContacto($id) {
    include 'bd.php';
    try{
        return $conn->query("SELECT id, nombre, primer_ap, segundo_ap, edad, direccion FROM contacto WHERE id = $id");
    } catch (Exception $e) {
        echo "Error!!" , $e->geMessage() . "<br>";
        return false;
    }
}