<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text" 
            placeholder="Nombre(s)" 
            id="nombre"
            value="<?php if(isset($contacto['nombre'])) echo $contacto['nombre']; else echo '' ?>"
            >
    </div>
    <div class="campo">
        <label for="primer_ap">Primer Apellido:</label>
        <input 
            type="text"     
            placeholder="Primer Apellido"   
            id="primer_ap"
            value="<?php if(isset($contacto['primer_ap'])) echo $contacto['primer_ap']; else echo '' ?>"
            >
    </div>
    <div class="campo">
        <label for="segundo_ap">Segundo Apellido:</label>
        <input 
            type="text" 
            placeholder="Segundo Apellido" 
            id="segundo_ap"
            value="<?php if(isset($contacto['segundo_ap'])) echo $contacto['segundo_ap']; else echo '' ?>"
            >
    </div>
    <div class="campo">
        <label for="edad">Edad:</label>
        <input 
            type="text" 
            placeholder="Edad" 
            id="edad"
            value="<?php if(isset($contacto['edad'])) echo $contacto['edad']; else echo '' ?>"
            >
    </div>
    <div class="campo">
        <label for="direccion">Dirección:</label>
        <input 
        type="text" 
        placeholder="Dirección" 
        id="direccion"
        value="<?php if(isset($contacto['direccion'])) echo $contacto['direccion']; else echo '' ?>"
        >
    </div>
</div>
<div class="campo enviar">
    <?php
        $textoBtn = (isset($contacto['direccion'])) ? 'Guardar' : 'Añadir';
        $accion = (isset($contacto['direccion'])) ? 'editar' : 'crear';
    ?>
    <input type="hidden" id="accion" value="<?php echo $accion; ?>">
     <?php if( isset( $contacto['id'] )) { ?>
          <input type="hidden" id="id" value="<?php echo $contacto['id']; ?>">
     <?php } ?>
    <input type="submit" value="<?php echo $textoBtn; ?>">
</div>