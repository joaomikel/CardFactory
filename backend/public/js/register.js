// --- GESTIÓN DE FOCO ---
        let lastFocusedElement;
        const mainContent = document.getElementById('main-content');

        function trapFocus(e, container) {
            const focusables = container.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusables.length === 0) return;
            const first = focusables[0];
            const last = focusables[focusables.length - 1];

            if (e.key === 'Tab') {
                if (e.shiftKey) { // Shift + Tab
                    if (document.activeElement === first) {
                        e.preventDefault();
                        last.focus();
                    }
                } else { // Tab
                    if (document.activeElement === last) {
                        e.preventDefault();
                        first.focus();
                    }
                }
            }
        }

        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const isActive = sidebar.classList.contains('active');

            if (!isActive) {
                // ABRIR
                lastFocusedElement = document.activeElement;
                sidebar.classList.add('active');
                overlay.classList.add('active');
                
                // Hacer visible y bloquear fondo
                sidebar.style.visibility = 'visible';
                mainContent.setAttribute('aria-hidden', 'true');
                mainContent.setAttribute('inert', '');

                // Mover foco
                setTimeout(() => {
                    const closeBtn = document.getElementById('closeBtn');
                    if (closeBtn) closeBtn.focus();
                }, 100);

                sidebar.addEventListener('keydown', handleSidebarKeydown);
            } else {
                // CERRAR
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                
                // Restaurar fondo
                mainContent.removeAttribute('aria-hidden');
                mainContent.removeAttribute('inert');

                setTimeout(() => { sidebar.style.visibility = 'hidden'; }, 300);

                if (lastFocusedElement) lastFocusedElement.focus();
                sidebar.removeEventListener('keydown', handleSidebarKeydown);
            }
        }

        function handleSidebarKeydown(e) {
            if (e.key === 'Escape') toggleMenu();
            trapFocus(e, document.getElementById('sidebar'));
        }

        // --- SCRIPT DE REGISTRO ---
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault(); 

            const form = this;
            const formData = new FormData(form);
            const btn = form.querySelector('.btn-register');
            const errorDiv = document.getElementById('js-errors');
            
            const originalText = btn.innerText;
            btn.innerText = 'Creando cuenta...';
            btn.disabled = true;
            btn.style.opacity = "0.7";
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';

            const fallbackName = formData.get('name');

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(async response => {
                const isSuccess = response.ok; 
                let data = {};
                try { data = await response.json(); } catch (e) {}

                if (!isSuccess) throw data;

                // Lógica de éxito: Guardar sesión manual
                const tokenToSave = data.token || 'session_login_manual_override';
                localStorage.setItem('auth_token', tokenToSave);

                const userToSave = data.user || { name: fallbackName, email: formData.get('email') };
                localStorage.setItem('user_data', JSON.stringify(userToSave));

                if (data.redirect_url) window.location.href = data.redirect_url;
                else if (response.redirected) window.location.href = response.url;
                else window.location.href = "{{ route('dashboard') }}";
            })
            .catch(error => {
                btn.innerText = originalText;
                btn.disabled = false;
                btn.style.opacity = "1";

                let errorMsg = "Ocurrió un error al registrarse.";
                if (error.errors) {
                    errorMsg = "<ul style='padding-left: 20px; text-align: left; margin: 0;'>";
                    for (const [key, messages] of Object.entries(error.errors)) {
                        errorMsg += `<li>${messages[0]}</li>`;
                    }
                    errorMsg += "</ul>";
                } else if (error.message) {
                    errorMsg = error.message;
                }

                errorDiv.innerHTML = errorMsg;
                errorDiv.style.display = 'block';
                // Poner foco en el mensaje de error para que el usuario sepa qué pasó
                errorDiv.setAttribute('tabindex', '-1');
                errorDiv.focus();
            });
        });
        
        // Inicialización para ocultar sidebar de la tabulación
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            if(sidebar) sidebar.style.visibility = 'hidden';
        });