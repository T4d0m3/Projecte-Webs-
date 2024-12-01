console.log("main.js cargado correctamente"); // Mensaje para depuración
const signInBtn = document.getElementById("signIn");
const signUpBtn = document.getElementById("signUp");
const firstForm = document.getElementById("form1");
const secondForm = document.getElementById("form2");
const container = document.querySelector(".container");

signInBtn.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
});

signUpBtn.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

// Asegúrate de no prevenir el envío del formulario si todo está correcto
firstForm.addEventListener("submit", (e) => {
    console.log('Sign Up form submitted!'); // Para depuración
    // e.preventDefault(); // Descomentar solo si necesitas detener el envío
});

secondForm.addEventListener("submit", (e) => {
    console.log('Sign In form submitted!'); // Para depuración
    // e.preventDefault(); // Descomentar solo si necesitas detener el envío
});
document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get('error');

    if (errorMessage) {
        // Crear la burbuja de error
        const bubble = document.createElement('div');
        bubble.textContent = errorMessage;
        bubble.className = 'error-bubble';
        document.body.appendChild(bubble); // Añadir la burbuja al body

        // Eliminar la burbuja después de 3 segundos
        setTimeout(() => {
            bubble.remove();
        }, 3000);

        // Eliminar el parámetro "error" de la URL sin recargar la página
        const newUrl = window.location.href.split('?')[0]; // Elimina todo después de "?"
        window.history.replaceState({}, document.title, newUrl); // Actualiza la URL
    }
});
