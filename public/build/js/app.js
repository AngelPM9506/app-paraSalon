let paso = 1;
let total = 0;
const pasoInicial = 1;
const pasoFinal = 3;
const cita = {
    id :'',
    nombre: '',
    fecha: '', 
    hora: '',
    servicios: []
}
document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); /**Mustra y oculata las secciones**/
    tabs(); /**Cambiar la seccion cuando se presionen los tobas**/
    botonesPaginador() /**Agrega o quita los botones del paginador**/
    /**Acciones dde los botones del paginador**/
    paginaSiguiente();/**Ir a la página siguiente**/
    paginaAnterior();/**Ir a la página anterior**/
    consultarAPI();/**Consulta la API en el backend de php**/
    nombreCliente();/**Añade el nombre y id del cliente al objeto de cita**/
    seleccionarFecha(); /**Añade la fecha de la cita al objeto cita**/
    seleccionarHora();/**Añade la hora de la cita al onjeto cita**/
    mostrarResumen(); /**Muestra el resumen de la cita**/
}
/**Mostrar la seccion dependiendo del nuero de paso**/
function mostrarSeccion() {
    /**Ocualtar la seccion que tenga la clase de mostrar**/
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    /**Seleccionar la seccion con el paso**/
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    /**quitar la clase de actual al anterior**/
    const tabActual = document.querySelector('.actual');
    if (tabActual) {
        tabActual.classList.remove('actual');
    }

    /**Resalta la etapa actual**/
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}
/**Funcion para navegar por los tabs**/
function tabs() {
    const botones = document.querySelectorAll('.tabs button');    
    botones.forEach( boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso); 
            /**Mostrar secciones**/
            mostrarSeccion();
            /**Cambiar orden de los botones**/
            botonesPaginador();
        });
    });
}
/**Mostrar los botones de paginacion **/
function botonesPaginador() {
    const paginaSiguiente = document.querySelector('#siguiente');
    const paginaAnterior = document.querySelector('#anterior');
    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar')
    }else if (paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}
function paginaSiguiente(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial ) {
            return
        }
        paso--;
        botonesPaginador();
    });
}
function paginaAnterior(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal ) {
            return
        }
        paso++;
        botonesPaginador();
    });
}
async function consultarAPI() {
    const server = window.location.origin;
    try {
        const url = `${server}/api/servicios`;
        //const url = `http://127.0.0.1:3000/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error.message);
        //alert('error en la aplicacion intenta de nuevo'.error);
    }
}
function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const{id, nombre, precio} = servicio;
        /**Nombre de servicio**/
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;
        /**Precio de servicio**/
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio} MXN`;
        /**Contenedor de los demas**/
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = () => {seleccionarServicio(servicio)};
        /**Agregar los demas componentes al div de servicio**/
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        /**incrustacion en el html principal**/
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}
function seleccionarServicio(servicio) {
    const { id, precio } = servicio;
    const { servicios } = cita;
    const divServicio = document.querySelector(`[data-id-servicio = "${id}"]`);
    /**Comprobar si un servicio ya fue agregado**/
    if ( servicios.some(agregado => agregado.id === id) ) {
        /**eliminarlo**/
        cita.servicios = servicios.filter( agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
        total -= parseFloat(precio);
        //console.log(total);
    }else{
        /**agregarlo**/
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
        total += parseFloat(precio);
        //console.log(total);
    }
    //console.log(cita);
}
function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
    cita.id = document.querySelector('#id').value
}
function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',(e)=>{
        const dia = new Date(e.target.value).getUTCDay();
        const hoy = new Date();
        if ([6, 0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('error','Los fines de semana no estan permitidos','.formulario');
        }else{
            /**No registrar nada si alteran el min del html**/
            if (e.target.value < hoy.toISOString().split('T')[0]) {
                mostrarAlerta('error','Introduce una fecha valida','.formulario');
                e.target.value = '';
                return;
            }else{
                cita.fecha = e.target.value;
            }
        }
    });
}
function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input',(e)=>{
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if (hora<10 || hora>=18) {
            e.target.value = '';
            mostrarAlerta('error','Horas no validas, nuestro horario es de 10:00 a 18:00','.formulario');
        }else{
            /**por hacer, hacer que solo se permita una cita cada cierta hora**/
            cita.hora = e.target.value;
        }
    });
}
function mostrarAlerta(tipo, mensaje, elemento, desaparece = true) {
    /**Previene que se genere mas de una alerta**/
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }
    /**script para cerar una alerta**/
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    /**mostrar la alerta en el parrafo**/
    const mostrar = document.querySelector(elemento);
    mostrar.appendChild(alerta);
    /**remover la alerta despues de 5s**/
    if (desaparece) {        
        setTimeout(()=>{alerta.remove()},5000);
    }
}
function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');
    /**Limpiar el contenido de resumen**/
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('error','no seleccionaste un servicio o falta la fecha u hora, intenta de nuevo.','.contenido-resumen', false);
        return;
    }
    /**Formatear el div de resumen**/
    const { nombre, fecha, hora, servicios } = cita;
    /**heading de servicios**/
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen De Servicios';
    /**heading de Datos citas**/
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen De Cita';
    /**Nombre**/
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
    /**Fecha**/
        /**formater la fecha en español**/
        const fechaFormateada = formateoFecha(fecha);
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
    /**Hora**/
    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;
    /**Div para contenido de datos de la cita**/
    const datosCita = document.createElement('DIV');
    datosCita.classList.add('datos-cita');
    datosCita.appendChild(headingCita);
    datosCita.appendChild(nombreCliente);
    datosCita.appendChild(fechaCita);
    datosCita.appendChild(horaCita);
    /**Se agregan al resumen los elementos creados enterior mente**/
    resumen.appendChild(headingServicios);
    /**Servicios**/
    servicios.forEach(servicio=>{
        const { id, nombre, precio } = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;
        precioServicio.classList.add('preocio-servicio');

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);
    });
    /**Agregar total**/
    const contenedorTotal = document.createElement('DIV');
    const textoTotal = document.createElement('P');
    textoTotal.innerHTML = `<span>Total:</span> $${total}.00`;
    contenedorTotal.appendChild(textoTotal);
    contenedorTotal.classList.add('contenedor-total');
    /**se agrega el total al resumen**/
    resumen.appendChild(contenedorTotal);
    /**Se agregan los datos de la cista hasta el final */
    resumen.appendChild(datosCita);
    /**Boton para crear una ciata**/
    const botonReserva = document.createElement('BUTTON');
    botonReserva.textContent = 'Reservar cita';
    botonReserva.classList.add('boton');
    botonReserva.onclick = reservarCita;
    resumen.appendChild(botonReserva);
}
/**Reservar cita**/
async function reservarCita() {
    const { id, fecha, hora, servicios} = cita; 
    const idServicios = servicios.map(servicio => servicio.id);
    const datos = new FormData();
    const server = window.location.origin;
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);
    try {
        /**peticion hacia la api**/
        const url = `${server}/api/citas`;
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();
        if (resultado.resultado) {
            Swal.fire({
            icon: 'success',
            title: 'Cita Creada',
            text: 'Muy bien tu cita fue guardada exitosamente',
            button: 'ok'
          }).then(()=>{
              setTimeout(()=>{
                window.location.reload();
              }, 150);
          });
        }        
    } catch (error) {
        console.log(error.message);
        Swal.fire({
            icon: 'error',
            title: '¡¡¡Error!!!',
            text: error,
            footer: '<a href="">Why do I have this issue?</a>'
          });
    }
    //console.log([...datos]);
}
/**Formatear fecha**/
function formateoFecha(fecha) {
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();
    const fechaUTC = new Date(Date.UTC(year,mes,dia));
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
    return fechaFormateada;
}