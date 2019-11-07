<?php 
    include 'inc/funciones/funciones.php'; 
    include 'inc/layout/header.php'; 
?>

<div class="contenedor-barra">
    <h1>Agenda de Contactos</h1>
</div>

<div class="bg-azul contenedor sombra">
    <form id="contacto" action="#">
        <legend>Añada un contacto <span>Todos los campos son obligatorios</span> </legend>

    <?php include 'inc/layout/formulario.php'; ?>
    </form>
</div>

<div class="bg-blanco contenedor sombra contactos">
    <div class="contenedor-contactos">
        <h2>Contactos</h2>

        <input type="text" id="buscar" class="buscador sombra" placeholder="Buscar Contactos...">

        <p class="total-contactos"><span></span> Contactos</p>

        <div class="contenedor-tabla">
            <table id="listado-contactos" class="listado-contactos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Edad</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $contactos = obtenerContactos(); 
                        
                        if($contactos->num_rows) {
                            
                            foreach($contactos as $contacto) { ?>
                            <tr>
                            
                        <td><?php echo $contacto['nombre']; ?></td>
                        <td><?php echo $contacto['primer_ap']; ?></td>
                        <td><?php echo $contacto['segundo_ap']; ?></td>
                        <td><?php echo $contacto['edad']; ?></td>
                        <td><?php echo $contacto['direccion']; ?></td>
                        <td>
                            <a class="btn-editar btn" href="editar.php?id=<?php echo $contacto['id']; ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button data-id="<?php echo $contacto['id']; ?>" type="button" class="btn-borrar btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>                        
                    <?php }
                } ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>  


<?php include 'inc/layout/footer.php'; ?>

