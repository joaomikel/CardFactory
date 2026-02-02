        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeSidebar');
            
            const isActive = sidebar.classList.toggle('active');
            overlay.classList.toggle('active');

            if (isActive) {
                // Al abrir, esperamos a la transición y ponemos el foco en el botón de cerrar
                setTimeout(() => {
                    closeBtn.focus();
                }, 300);
            } else {
                // Al cerrar, devolvemos el foco al botón que lo abrió
                menuBtn.focus();
            }
        }

        // Lógica de validación de formulario (se mantiene la tuya)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            const form = this;
            const btn = form.querySelector('.btn-login');
            const originalText = btn.innerText;

            btn.innerText = 'Entrando...';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.ok ? response.json() : response.json().then(err => { throw err; }))
            .then(data => {
                if (data.token) {
                    sessionStorage.setItem('auth_token', data.token);
                    sessionStorage.setItem('user_data', JSON.stringify(data.user));
                }
                window.location.href = "http://localhost/dashboard";
            })
            .catch(error => {
                btn.innerText = originalText;
                btn.disabled = false;
                alert("❌ " + (error.message || "Credenciales incorrectas"));
            });
        });