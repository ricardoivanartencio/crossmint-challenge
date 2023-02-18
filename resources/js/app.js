

document.addEventListener('DOMContentLoaded', function() {

    hideOverlay();

    const closeButton = document.querySelector('.alert button[data-bs-dismiss="alert"]');
    if (closeButton) {
        closeButton.addEventListener('click', (event) => {
            // Evita que el enlace cambie la URL de la página
            event.preventDefault();

            // Oculta la alerta
            const alert = event.target.closest('.alert');
            alert.classList.add('d-none');
        });
    }
});


