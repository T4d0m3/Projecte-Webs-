document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formulario.php'); // Define aquí tu formulario
    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Previene el envío por defecto

        const formData = {
            problemType: document.getElementById('problemType').value,
            description: document.getElementById('description').value,
            urgency: document.getElementById('urgencySlider').value,
        };

        try {
            const response = await fetch('formulario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            if (response.ok) {
                const result = await response.text();
                alert(`Protocolo de Resolución Completado\n\n${result}`);
            } else {
                alert('Error al enviar el formulario.');
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            alert('Ocurrió un problema al enviar el formulario.');
        }
    });
});
