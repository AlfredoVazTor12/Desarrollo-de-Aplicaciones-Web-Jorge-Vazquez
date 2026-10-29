// ==========================================
// PASO 2: OBTENER Y MOSTRAR LA FECHA ACTUAL
// ==========================================
const contenedorFecha = document.getElementById('fecha-actual');
const fecha = new Date();
const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
// Formatear fecha y convertir a mayúsculas para mantener el estilo corporativo
contenedorFecha.textContent = fecha.toLocaleDateString('es-ES', opcionesFecha).toUpperCase();


// ==========================================
// PASO 1: VALIDACIÓN DE FORMULARIOS
// ==========================================
const formulario = document.getElementById('form-proyecto');

formulario.addEventListener('submit', function(evento) {
    // Evitar que el formulario recargue la página automáticamente
    evento.preventDefault();

    // Obtener los valores de los campos (trim elimina espacios en blanco)
    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const tecnologia = document.getElementById('tecnologia').value;
    const repositorio = document.getElementById('repositorio').checked;

    // Expresión regular para validar formato de correo
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Variables para almacenar el error
    let mensajeError = "";

    // 1. Validar campo de texto (Requerido y longitud)
    if (nombre === "") {
        mensajeError = "El nombre del proyecto es obligatorio.";
    } else if (nombre.length < 4) {
        mensajeError = "El nombre debe tener al menos 4 caracteres.";
    }
    // 2. Validar formato de correo electrónico
    else if (email === "") {
        mensajeError = "El correo del líder técnico es obligatorio.";
    } else if (!regexEmail.test(email)) {
        mensajeError = "Por favor, introduce un correo electrónico válido.";
    }
    // 3. Validar control Select (Menú desplegable)
    else if (tecnologia === "") {
        mensajeError = "Debes seleccionar una tecnología principal.";
    }
    // 4. Validar control Checkbox (Ejemplo de validación de lógica de negocio)
    else if (!repositorio) {
        // En este caso, forzamos a que acepten crear el repo como ejemplo
        mensajeError = "Debes aceptar crear el repositorio público.";
    }

    // Si hay un error, mostramos la alerta de la biblioteca externa (SweetAlert2)
    if (mensajeError !== "") {
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            text: mensajeError,
            confirmButtonColor: '#0052cc',
            customClass: { popup: 'square-popup' } // Forzar cuadrado
        });
        return; // Detener la ejecución
    }

    // Si pasa todas las validaciones
    Swal.fire({
        icon: 'success',
        title: '¡Proyecto Guardado!',
        text: `El proyecto "${nombre}" ha sido registrado correctamente.`,
        confirmButtonColor: '#28a745',
        customClass: { popup: 'square-popup' }
    });

    // Limpiar formulario tras éxito
    formulario.reset();
});


// ==========================================
// PASO 2: CALCULADORA FUNCIONAL EN JAVASCRIPT
// ==========================================
const calcDisplay = document.getElementById('calc-display');
let currentCalc = "";

// Función para agregar números o símbolos
function calcInput(valor) {
    if (calcDisplay.value === "0" || calcDisplay.value === "Error") {
        currentCalc = valor;
    } else {
        currentCalc += valor;
    }
    calcDisplay.value = currentCalc;
}

// Función para limpiar la pantalla (Botón C)
function calcClear() {
    currentCalc = "";
    calcDisplay.value = "0";
}

// Función para evaluar la operación matemática (Botón =)
function calcEval() {
    try {
        // Eval procesa el string como operación matemática
        const resultado = eval(currentCalc);
        // Si el resultado es válido, lo mostramos
        if (resultado !== undefined) {
            calcDisplay.value = resultado;
            currentCalc = resultado.toString();
        }
    } catch (error) {
        // Si el usuario ingresa algo inválido (ej: "5++5")
        calcDisplay.value = "Error";
        currentCalc = "";
    }
}