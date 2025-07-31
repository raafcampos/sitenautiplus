document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const formStatus = document.getElementById('form-status');
    const submitButton = contactForm ? contactForm.querySelector('button[type="submit"]') : null;

    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(contactForm);
            submitButton.disabled = true;
            submitButton.textContent = 'Enviando...';
            const statusDiv = formStatus;
            statusDiv.innerHTML = 'Enviando...';

            fetch(contactForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    contactForm.reset(); // Limpa o formulário
                    statusDiv.style.color = 'green';
                } else {
                    statusDiv.style.color = 'red';
                }
                return response.text();
            })
            .then(text => {
                statusDiv.innerHTML = text;
                submitButton.disabled = false;
                submitButton.textContent = 'Enviar Mensagem';
            })
            .catch(error => {
                statusDiv.innerHTML = 'Ocorreu um erro ao enviar o formulário.';
                submitButton.disabled = false;
                submitButton.textContent = 'Enviar Mensagem';
                console.error('Error:', error);
            });
        });
    }
});