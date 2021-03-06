eventListeners();

let listaProyectos = document.querySelector('ul#proyectos');

function eventListeners() {
    // boton para crear proyecto
    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoProyecto);
}

function nuevoProyecto(e) {
    e.preventDefault;
    // crea un input para el nombre del nuevo proyecto
    let nuevoProyecto = document.createElement('li');
    nuevoProyecto.innerHTML = '<input type=text id="nuevo-proyecto">';
    listaProyectos.appendChild(nuevoProyecto);

    // Seleccionar el id con el nuevo proyecto
    let inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    // al presionar enter crear el proyecto
    inputNuevoProyecto.addEventListener('keypress', function(e){ // el keypress nos permite ver la tecla que se ha tocado
        let tecla = e.which || e.keyCode;
        
        if(tecla === 13) {
            guardarProyectoDB(inputNuevoProyecto.value); // se manda parametros a esa funcion, en este caso el value de la variable inputNuevoProyecto
            listaProyectos.removeChild(nuevoProyecto); // una vez que se guarde el proyecto se hace un remove del nuevoProyecto, de esta manera desaparece el input
        }
    });

}

function guardarProyectoDB(nombreProyecto) {
    // enviar datos
    let datos = new FormData();
    datos.append('proyecto', nombreProyecto);
    datos.append('accion', 'crear');

    // Crear llamado
    let xhr = new XMLHttpRequest();

    // abrir conexion
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    // retorno de datos
    xhr.onload = function() {
        if(this.status === 200) {
            let respuesta = JSON.parse(xhr.responseText);
            console.log(respuesta);

            // si la respuesta es correcto
            if(respuesta.respuesta === 'correcto') {
                // nuevo proyecto
                if(respuesta.tipo === 'crear') {
                    swal({
                        title: 'Proyecto Creado',
                        text: 'El proyecto se creo correctamente',
                        type: 'success'
                    })
                }
            } else {
                swal({
                    title: 'El proyecto no se pudo crear',
                    text: 'Hubo un error con el proyecto',
                    type: 'error'
                });
            }
        }
    }

    // enviar el request
    xhr.send(datos);
}