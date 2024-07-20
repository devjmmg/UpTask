(function () {
    
    let tareas = [];
    let filtradas = [];
    
    obtenerTareas();
    
    const agregarTarea = document.querySelector("#agregar-tarea");
    agregarTarea.addEventListener('click', function() {
        mostrarFormulario();
    });

    //Filtros de búsqueda
    const filtros = document.querySelectorAll("input[type='radio']");
    filtros.forEach( radio => {

        radio.addEventListener('input',filtrarTarea);

    });

    function filtrarTarea(e) {

        const filtro = e.target.value;

        if(filtro !== "") {

            filtradas = tareas.filter( tarea => tarea.estado ===  filtro);

        }else{

            filtradas = [];

        }

        limpiarTareas();
        mostrarTareas();

    }
    
    async function obtenerTareas() {
        
        try {
            
            const url = `http://localhost:3000/api/tareas?id=${obtenerProyecto()}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            
            tareas = resultado;
            
            mostrarTareas();
            
        } catch (error) {
            console.log(error);
        }
        
    }
    
    function mostrarTareas() {

        totalPendientes();
        totalCompletas();
        
        const arrayTareas = filtradas.length ? filtradas : tareas;
        const lista = document.querySelector("#listar-tareas");
        
        if(arrayTareas.length === 0) {
            
            const li = document.createElement("LI");
            li.textContent = "No hay tareas...";
            li.classList.add("no-tareas");
            lista.appendChild(li);
            
            return;
            
        }
        
        estados = {
            0: "Pendiente",
            1: "Completa"
        }
        
        arrayTareas.forEach( tarea => {
            
            const li = document.createElement("LI");
            li.dataset.id = tarea.id;
            li.classList.add("tarea");
            
            const nombre = document.createElement("P");
            nombre.textContent = tarea.tarea;
            nombre.ondblclick = function() {
                mostrarFormulario(true,{...tarea});
            }
            
            const opciones  = document.createElement("DIV");
            opciones.classList.add("opciones");
            
            const estado = document.createElement("BUTTON");
            estado.classList.add("estado-tarea");
            estado.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            estado.textContent = estados[tarea.estado];
            estado.dataset.estadoTarea = tarea.estado;
            estado.ondblclick = function () {
                cambiarEstadoTarea({...tarea});
            }
            
            const btnEliminar = document.createElement("BUTTON");
            btnEliminar.classList.add("eliminar-tarea");
            btnEliminar.dataset.idTarea = tarea.id;
            btnEliminar.textContent = "Eliminar tarea";
            btnEliminar.ondblclick = function () {
                confirmarEliminarTarea({...tarea});
            }
            
            opciones.appendChild(estado);
            opciones.appendChild(btnEliminar);
            
            
            li.appendChild(nombre);
            li.appendChild(opciones);
            
            lista.appendChild(li);
            
        });
        
    }
    
    function mostrarFormulario(editar = false,tarea = {}) {
        
        const modal = document.createElement("DIV");
        modal.classList.add("modal");
        modal.innerHTML = `
        
        <form class="formulario form-nueva-tarea">
                <legend>${editar ? 'Editar tarea':'Añade una nueva tarea'}</legend>
        
               <div class="campo">
                    <label for="tarea">Tarea:</label>
                    <input type="text" name="tarea" id="tarea" placeholder="Nombre de la tarea" value="${editar ? tarea.tarea:"" }">
                </div>
        
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="${editar ? 'Editar tarea':'Añadir nueva tarea'}">
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
        </form>
        
        `;
        
        setTimeout(function () {
            
            const form = document.querySelector("form");
            form.classList.add("animar");
            
        },0);
        
        modal.addEventListener('click',function(e) {
            
            e.preventDefault();
            
            if(e.target.classList.contains("cerrar-modal")) {
                
                const form = document.querySelector("form");
                form.classList.add("cerrar");
                
                setTimeout(function () {
                    
                    modal.remove();
                    
                },300);
                
            }
            
            if(e.target.classList.contains("submit-nueva-tarea")) {
                
                const nombreTarea = document.querySelector("#tarea").value.trim();
                
                if(nombreTarea === "") {
                    
                    mostrarAlerta("error","El nombre de la tarea es obligatoria",document.querySelector(".formulario legend"));
                    return;
                }
                
                if(editar) {
                    
                    tarea.tarea = nombreTarea;
                    actualizarTarea(tarea);
                    
                }else{
                    
                    agregarTareaForm(nombreTarea);
                    
                }
                
            }
            
        });
        
        document.querySelector(".dashboard").appendChild(modal);
        
    }
    
    function mostrarAlerta(tipo,alerta,referencia){
        
        const alertaPrevia = document.querySelector(".alerta");
        if(alertaPrevia){
            alertaPrevia.remove();
        }
        
        const div = document.createElement("DIV");
        div.classList.add("alerta",tipo);
        div.textContent = alerta;
        
        //Inserta antes de la etiqueta legend
        // referencia.parentElement.insertBefore(div,referencia);
        
        //Inserta despues de la etiqueta legend
        referencia.parentElement.insertBefore(div,referencia.nextElementSibling);
        
        setTimeout( () => {
            div.remove();
        },3000 );
        
    }
    
    async function agregarTareaForm(tarea) {
        
        const formData = new FormData;
        formData.append("tarea",tarea);
        formData.append("proyecto_id",obtenerProyecto());
        
        try {
            
            const url = "http://localhost:3000/api/tarea";
            
            const respuesta = await fetch(url, {
                method: "POST",
                body: formData
            });
            
            const resultado = await(respuesta.json());
            
            mostrarAlerta(resultado.tipo,resultado.mensaje,document.querySelector(".formulario legend"));
            
            if(resultado.tipo === "exito") {
                const modal = document.querySelector(".modal");
                setTimeout(() => {
                    
                    modal.remove();
                    
                }, 2000);
                
                //Agregar el objeto
                const nuevo = {
                    id: resultado.id,
                    tarea: tarea,
                    estado: "0",
                    proyecto_id: resultado.proyecto_id
                }
                
                tareas = [...tareas,nuevo];
                
                limpiarTareas();
                
                mostrarTareas();
                
            }
            
        } catch (error) {
            
            console.log(error);
            
        }
        
    }
    
    function cambiarEstadoTarea(tarea) {
        
        const nuevoEstado = tarea.estado === "1" ? "0":"1";
        tarea.estado = nuevoEstado;
        
        actualizarTarea(tarea);
        
    }
    
    async function actualizarTarea(t) {
        
        const {id, tarea, estado} = t;
        
        const datos = new FormData;
        datos.append("id",id);
        datos.append("tarea",tarea);
        datos.append("estado",estado);
        datos.append("proyecto_id",obtenerProyecto());
        
        try {
            
            const url = "/api/tarea/actualizar";
            const respuesta = await fetch(url,{
                method: "POST",
                body: datos
            });
            const resultado = await respuesta.json();
            
            if(resultado.respuesta.tipo === "exito"){
                
                //mostrarAlerta(resultado.respuesta.tipo,resultado.respuesta.mensaje,document.querySelector(".nueva-tarea"));
                Swal.fire("Actualizado!", resultado.respuesta.mensaje, "success");
                
                const modal = document.querySelector(".modal");
                if(modal){
                    modal.remove();
                }
                
                tareas = tareas.map( (tareaMemoria) => {
                    if(tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.tarea = tarea;
                    }
                    
                    return tareaMemoria;
                });
                
                limpiarTareas();
                mostrarTareas();
                
            }
            
        } catch (error) {
            
        }
        
    }
    
    function confirmarEliminarTarea(t) {
        
        Swal.fire({
            title: "¿Eliminar la tarea?",
            showCancelButton: true,
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                
                eliminarTarea(t);
                
            }
        });
        
    }
    
    async function eliminarTarea(t) {
        
        const {id, tarea, estado} = t;
        
        const datos = new FormData;
        datos.append("id",id);
        datos.append("tarea",tarea);
        datos.append("estado",estado);
        datos.append("proyecto_id",obtenerProyecto());
        
        try {
            
            const url = "/api/tarea/eliminar";
            
            const respuesta = await fetch(url,{
                method: "POST",
                body: datos
            });
            const resultado = await respuesta.json();
            
            if(resultado.resultado) {
                
                //mostrarAlerta(resultado.tipo,resultado.mensaje,document.querySelector(".nueva-tarea"));
                Swal.fire("Eliminado!", resultado.mensaje, "success");
                
                tareas = tareas.filter( tareaMemoria => tareaMemoria.id !== id );
                
                limpiarTareas();
                
                mostrarTareas();
                
            }
            
        } catch (error) {
            console.log(error);
        }
        
    }
    
    function obtenerProyecto() {
        
        const proyectoParams = new URLSearchParams(window.location.search); //Me devuelve los parametros
        const proyecto = Object.fromEntries(proyectoParams); // Convierte todo en un objeto
        return proyecto.id; //Muestra el valor del objecto 
        
    }
    
    function limpiarTareas() {
        
        const lista = document.querySelector("#listar-tareas");
        while(lista.firstChild) {
            lista.removeChild(lista.firstChild);
        }
        
    }

    function totalPendientes() {

        const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
        const pendiente = document.querySelector("#pendiente");

        if(totalPendientes.length === 0) {
            pendiente.disabled = true;
        }else{
            pendiente.disabled = false;
        }

    }

    function totalCompletas() {

        const totalCompletas = tareas.filter(tarea => tarea.estado === "1");
        const completa = document.querySelector("#completa");

        if(totalCompletas.length === 0) {
            completa.disabled = true;
        }else{
            completa.disabled = false;
        }

    }
    
    
})();