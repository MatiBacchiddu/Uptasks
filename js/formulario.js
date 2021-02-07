eventListeners();

function eventListeners()
{
    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e) {
    e.preventDefault();
    let usuario = document.querySelector('#usuario').value,
        password = document.querySelector('#password').value,
        tipo = document.querySelector('#tipo').value;

    if(usuario == '' || password == '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ambos campos son obligatorios',
          });
    } else {    
        // ambos campos son correctos ejecutar ajax
        let datos = new FormData();

        // datos que se envian al server
        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('accion', tipo);

        // crear el llamado ajax
        let xhr = new XMLHttpRequest();
        
        // abrir conexion
        xhr.open('POST', 'inc/modelos/modelo-admin.php', true);

        // retorno de datos
        xhr.onload = function() {
            if(this.status === 200) {
                // console.log(JSON.parse(xhr.responseText));
                var respuesta = JSON.parse(xhr.responseText);
                
                console.log(respuesta);
                // SI la respuesta es correcta
                if(respuesta.respuesta === 'correcto') {
                    // si es un nuevo usuario
                    if(respuesta.tipo === 'crear') { // si el tipo de respuesta es crear, quiere decir que es un usuario nuevo
                        swal({
                            title: 'Usuario Creado',
                            text: 'El usuario se creo correctamente',
                            type: 'success'
                        });

                    } else if(respuesta.tipo === 'login') {
                        swal({
                            title: 'Login correcto',
                            text: 'Presiona OK para abrir el dashboard',
                            type: 'success'
                        })
                        .then( resultado => {
                            if(resultado.value) {
                                window.location.href = 'index.php';
                            }
                        })
                    }
                    
                }  else {
                    // hubo un error
                    swal({
                        title: 'Error',
                        text: 'Hubo un error',
                        type: 'error'
                    });
                }
            }
        }

        // enviar la peticion
        xhr.send(datos);

    }
}