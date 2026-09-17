window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        header.classList.toggle('scrolled', window.scrollY > 50);
    });

document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const responseDiv = document.getElementById('formResponse');
        responseDiv.innerHTML = '<span class="text-info">Sending message...</span>';

        fetch('php/contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                responseDiv.innerHTML = `<span class="text-success">${data.message}</span>`;
                form.reset();
            } else {
                responseDiv.innerHTML = `<span class="text-danger">${data.message}</span>`;
            }
        })
        .catch(error => {
            responseDiv.innerHTML = '<span class="text-danger">An error occurred. Please try again.</span>';
        });
    });