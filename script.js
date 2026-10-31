
const contenedorFecha = document.getElementById('fecha-actual');
if (contenedorFecha) {
    const fecha = new Date();
    const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    contenedorFecha.textContent = fecha.toLocaleDateString('es-ES', opcionesFecha).toUpperCase();
}

const formulario = document.getElementById('form-proyecto');

if (formulario) {
    formulario.addEventListener('submit', function(evento) {
        evento.preventDefault();

        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        const tecnologia = document.getElementById('tecnologia').value;
        const repositorio = document.getElementById('repositorio').checked;
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let mensajeError = "";

        if (nombre === "") {
            mensajeError = "El nombre del proyecto es obligatorio.";
        } else if (nombre.length < 4) {
            mensajeError = "El nombre debe tener al menos 4 caracteres.";
        } else if (email === "") {
            mensajeError = "El correo del líder técnico es obligatorio.";
        } else if (!regexEmail.test(email)) {
            mensajeError = "Por favor, introduce un correo electrónico válido.";
        } else if (tecnologia === "") {
            mensajeError = "Debes seleccionar una tecnología principal.";
        } else if (!repositorio) {
            mensajeError = "Debes aceptar crear el repositorio público.";
        }

        if (mensajeError !== "") {
            Swal.fire({
                icon: 'error',
                title: 'Error de Validación',
                text: mensajeError,
                confirmButtonColor: '#0052cc',
                customClass: { popup: 'square-popup' },
                showClass: { popup: '', backdrop: '' },
                hideClass: { popup: '', backdrop: '' }
            });
            return; 
        }

        Swal.fire({
            icon: 'success',
            title: '¡Proyecto Guardado! (Prueba)',
            text: `El proyecto "${nombre}" ha sido registrado correctamente.`,
            confirmButtonColor: '#28a745',
            customClass: { popup: 'square-popup' },
            showClass: { popup: '', backdrop: '' },
            hideClass: { popup: '', backdrop: '' }
        });

        formulario.reset();
    });
}


const calcDisplay = document.getElementById('calc-display');
let currentCalc = "";

function calcInput(valor) {
    if(!calcDisplay) return;
    if (calcDisplay.value === "0" || calcDisplay.value === "Error") {
        currentCalc = valor;
    } else {
        currentCalc += valor;
    }
    calcDisplay.value = currentCalc;
}

function calcClear() {
    if(!calcDisplay) return;
    currentCalc = "";
    calcDisplay.value = "0";
}

function calcEval() {
    if(!calcDisplay) return;
    try {
        const resultado = eval(currentCalc);
        if (resultado !== undefined) {
            calcDisplay.value = resultado;
            currentCalc = resultado.toString();
        }
    } catch (error) {
        calcDisplay.value = "Error";
        currentCalc = "";
    }
}

