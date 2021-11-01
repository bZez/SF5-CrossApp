let forms = document.querySelectorAll('.needs-validation')
forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault()
        if (!form.checkValidity()) {
            disableSpinners(form.submit)
            event.stopPropagation();
        } else {
            if (form.name === "loginForm") {
                let data = new FormData(form);
                fetch(form.action, {
                    method: "POST",
                    body: data,
                    credentials: 'same-origin'
                }).then(r => {
                    if (!r.ok) {
                        form.reset();
                        disableSpinners(form.submit)
                        return r.json()
                    }
                    return r.text()
                }).then(data => {
                    if (data.status !== 400)
                        genLink(window.location.href + '@home');
                })
            } else {
                //Your customs actions if needed...
            }
        }
        form.classList.add('was-validated');
    }, false)
});