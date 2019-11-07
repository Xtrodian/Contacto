const formularioContactos = document.querySelector('#contacto'),
      listadoContactos = document.querySelector('#listado-contactos tbody'),
      inputBuscador = document.querySelector('#buscar');

eventListeners();

function eventListeners(){
    // Cuando el formulario de crear o editar se ejecuta
    formularioContactos.addEventListener('submit', leerFormulario);

    // Listener para eliminar el boton
    if(listadoContactos) {
        listadoContactos.addEventListener('click', eliminarContacto);
   }

    // buscador
    inputBuscador.addEventListener('input', buscarContactos);
     
    numeroContactos();
}

function leerFormulario(e) { 
    e.preventDefault();

    //console.log('Presionaste...')
    // leer los datos  de las inputs
    const nombre = document.querySelector('#nombre').value,
          primer_ap = document.querySelector('#primer_ap').value,
          segundo_ap = document.querySelector('#segundo_ap').value,
          edad = document.querySelector('#edad').value,
          direccion = document.querySelector('#direccion').value,
          accion = document.querySelector('#accion').value;

          if(nombre === '' || primer_ap  === '' || segundo_ap  === '' || edad  === '' || direccion  === '')
          {
              //2 parametros: texto clase
              mostrarNotificacion('Todos los campos son obligatorios','error');
          } else {
              // Pasa la validacion, crear llamada a Ajax
              const infoContacto = new FormData();
              infoContacto.append('nombre',nombre);
              infoContacto.append('primer_ap',primer_ap);
              infoContacto.append('segundo_ap',segundo_ap);
              infoContacto.append('edad',edad);
              infoContacto.append('direccion',direccion);
              infoContacto.append('accion',accion);


              if( accion === 'crear'){
                    // Crear nuevo contacto
                    insertarBD(infoContacto);
              } else {  
                    // Editar el contacto
                    // leer el id
                    const idRegistro = document.querySelector('#id').value;
                    infoContacto.append('id',idRegistro);
                    actualizarRegistro(infoContacto);
              }
          }
}
/**  Insertar en la base de datos via Ajax */

function insertarBD(datos){
    // llamado a ajax

    //crear el objeto
    const xhr = new XMLHttpRequest();
    
    // abrir la conexion
    xhr.open('POST', 'inc/modelos/modelos-contactos.php', true);

    // pasar los datos
    xhr.onload = function() {
        if(this.status === 200) {
            console.log(JSON.parse( xhr.responseText) );
            // leemos la respuesta de php
            const respuesta = JSON.parse( xhr.responseText);

            // Inserta un nuevo elemento a la tabla
            const nuevoContacto = document.createElement('tr');

            nuevoContacto.innerHTML = `
                <td>${respuesta.datos.nombre}</td>
                <td>${respuesta.datos.primer_ap}</td>
                <td>${respuesta.datos.segundo_ap}</td>
                <td>${respuesta.datos.edad}</td>
                <td>${respuesta.datos.direccion}</td>
            `;

            // crear contenedor para los botones
            const contenedorAcciones = document.createElement('td');

            // crear el icono de editar
            const iconoEditar = document.createElement('i');
            iconoEditar.classList.add('fas', 'fa-pen');

            // crear el enlace para editar
            const btnEditar = document.createElement('a');
            btnEditar.appendChild(iconoEditar);
            btnEditar.href = `editar.php?id=${respuesta.datos.id_insertado}`;
            btnEditar.classList.add('btn', 'btn-editar');

            // agregarlo al padre
            contenedorAcciones.appendChild(btnEditar);

            // crear el icono de eliminar
            const iconoEliminar = document.createElement('i');
            iconoEliminar.classList.add('fas', 'fa-trash');

            // crear el boton de eliminar
            const btnEliminar = document.createElement('button');
            btnEliminar.appendChild(iconoEliminar);
            btnEliminar.setAttribute('data-id', respuesta.datos.id_insertado);
            btnEliminar.classList.add('btn', 'btn-borrar');

             // agregarlo al padre
            contenedorAcciones.appendChild(btnEliminar);

            // Agregarlo al tr
            nuevoContacto.appendChild(contenedorAcciones);

            // agregarlo con los contactos
            listadoContactos.appendChild(nuevoContacto);


            // Resetear el formulario
            document.querySelector('form').reset();
            // mostrar notificacion
            mostrarNotificacion('Contacto Creado Correctamente', 'correcto');

            // Actualizar el numero
            numeroContactos();
        }
    }

    // enviar los datos
    xhr.send(datos)
}

function actualizarRegistro(datos) {
    // crear el objeto
    const xhr = new XMLHttpRequest();

    // abrir la conexion
    xhr.open('POST', `inc/modelos/modelo-editar.php?`,true);

    // leer el contacto
    xhr.onload = function() {
        if(this.status === 200 ) {
            console.log(JSON.parse(xhr.responseText));
            const respuesta = JSON.parse(xhr.responseText);

            if(respuesta.respuesta === 'correcto') {
                // mostrar notificacion en correcto
                mostrarNotificacion('Contacto Editado Correctamente','correcto');
            } else {
                // hubo un error
                mostrarNotificacion('Hubo un error','error');
            }
            // console.log(respuesta);
        }
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 1000);
    }

    // enviar la peticion
    xhr.send(datos);
}

function eliminarContacto(e) {
    if( e.target.parentElement.classList.contains('btn-borrar') ) {
        // tomar el ID
        const id = e.target.parentElement.getAttribute('data-id');

        // confirmacion al usuario
        const respuesta = confirm('Estas seguro (a) ?');

        if(respuesta) {
            // llamado a ajax
            //crear el objeto
            const xhr = new XMLHttpRequest();

            // arbir la conexcion
            xhr.open('GET', `inc/modelos/modelo-borrar.php?id=${id}&accion=borrar`, true);

            // leer la respuesta
            xhr.onload = function() {
                if(this.status === 200) {
                   const resultado = JSON.parse(xhr.responseText);
                      
                         if(resultado.respuesta == 'correcto') {
                              // Eliminar el registro del DOM
                              console.log(e.target.parentElement.parentElement.parentElement);
                              e.target.parentElement.parentElement.parentElement.remove();

                              // mostrar Notificación
                              mostrarNotificacion('Contacto eliminado', 'correcto');

                              // Actualizar el número
                              numeroContactos();
                         } else {
                              // Mostramos una notificacion
                              mostrarNotificacion('Hubo un error...', 'error' );
                         }

                    }                
            }
            // enviar la peticion
            xhr.send();
        }
    }
}

/** Buscador de registros */
function buscarContactos(e) {
    const expresion = new RegExp(e.target.value, "i" );
          registros = document.querySelectorAll('tbody tr');

          registros.forEach(registro => {
               registro.style.display = 'none';

               if(registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1 ){
                    registro.style.display = 'table-row';
               }
               numeroContactos();
          })
}

/** Muestra el número de Contactos */
function numeroContactos() {
     const totalContactos = document.querySelectorAll('tbody tr'),
          contenedorNumero = document.querySelector('.total-contactos span');

     let total = 0;

     totalContactos.forEach(contacto => {
          if(contacto.style.display === '' || contacto.style.display === 'table-row'){
               total++;
          }
     });

     // console.log(total);
     contenedorNumero.textContent = total;
}


function mostrarNotificacion(mensaje, clase) {
    const notificacion = document.createElement('div');
    notificacion.classList.add(clase, 'notificacion', 'sombra');
    notificacion.textContent = mensaje;

    // formulario
    formularioContactos.insertBefore(notificacion, document.querySelector('form legend'));

    // Ocultar y mostrar la notificacion
    setTimeout(() => {
        notificacion.classList.add('visible');

        setTimeout(() => {
            notificacion.classList.remove('visible');
            setTimeout(() => {
                notificacion.remove();
            }, 500)
        }, 3000);
    }, 100);
}