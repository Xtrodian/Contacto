<?php 
    include 'inc/funciones/funciones.php';
    include 'inc/layout/header.php'; 

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if(!$id) {
        die('No es válido');
    }

    $resultado = obtenerContacto($id);
    $contacto = $resultado->fetch_assoc();

?>


<div class="contenedor-barra">
    <div class="contenedor barra">
        <a href="index.php" class="volver">Volver</a>
        <h1>Editar Contacto</h1>
    </div>
</div>

<div class="bg-azul contenedor sombra">
    <form id="contacto" action="#">
        <legend>Edite el  Contacto</legend>
        <?php include 'inc/layout/formulario.php'; ?>
    </form>
</div>

<?php include 'inc/layout/footer.php'; ?>
