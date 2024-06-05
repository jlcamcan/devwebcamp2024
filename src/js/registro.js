import Swal from 'sweetalert2';
(function() {
    let eventos = [];
    const resumen = document.querySelector('#registro-resumen');
    if (resumen) {
        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));
        //Validar registro y regalo
        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitFormulario);

        mostrarEventos();

        function seleccionarEvento(e) {
            if (eventos.length < 5) {
                //Desahabilitar el evento
                e.target.disabled = true;
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]
                mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Máximo 5 eventos por registro',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
        }

        function mostrarEventos() {
            //Limpiar el HTML
            limpiarEventos();
            if (eventos.length > 0) {
                eventos.forEach(evento => {
                    const eventoDOM = document.createElement('DIV');
                    eventoDOM.classList.add('registro__evento');
                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;

                    //Boton de eliminar el evento
                    const botonEliminar = document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`
                    botonEliminar.onclick = function() {
                            eliminarEvento(evento.id);
                        }
                        //Añadimos los datos html
                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                })
            } else {
                const noSeleccion = document.createElement('P');
                noSeleccion.textContent = 'Sin eventos seleccionados, añade hasta un máximo de 5';
                noSeleccion.classList.add('registro__texto');
                resumen.appendChild(noSeleccion);
            }
        }
        //Borra el primer elemento del array
        function limpiarEventos() {
            while (resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        function eliminarEvento(id) {
            eventos = eventos.filter(evento => evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }

        async function submitFormulario(e) {
            e.preventDefault();
            //Obtener el regalo
            const regaloId = document.querySelector('#regalo').value;
            //Obtener los id de los eventos
            const eventosId = eventos.map(evento => evento.id);
            //Validar eventos y regalo
            if (eventosId.length === 0 || regaloId === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Debes seleccionar un Evento como mínimo y un Regalo',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return;
            }
            //Objeto a enviar a conferencias
            const datos = new FormData();
            datos.append('eventos', eventosId);
            datos.append('regalo_id', regaloId);

            const url = '/finalizar-registro/conferencias';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            })
            const resultado = await respuesta.json();
            console.log(resultado);
            if (resultado.resultado) {
                Swal.fire(
                    'Registro realizado correctamente',
                    'Tus Eventos se ha almacenado, te esperamos en DevWebCamp',
                    'success'
                ).then(() => location.href = `/ticket?id=${resultado.token}`);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error en tu Registro, vuelve a realizar el Registro',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => location.reload())
            }
        }
    } //fin if resumen 
})();