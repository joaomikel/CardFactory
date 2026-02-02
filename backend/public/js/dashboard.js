// --- LOGOUT ---
        document.getElementById('logoutForm').addEventListener('submit', function() {
            sessionStorage.removeItem('auth_token');
            sessionStorage.removeItem('user_data');
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
        });

        // --- TABS ---
        $( function() {
            $( "#tabs" ).tabs({
                show: { effect: "fade", duration: 300 },
                hide: { effect: "fade", duration: 300 }
            });
        } );

        // --- LÓGICA DEL MODAL ---
        function openEditModal(id, name, price, condition, setId) {
            // 1. Rellenar datos
            document.getElementById('modalName').value = name;
            document.getElementById('modalPrice').value = price;
            document.getElementById('modalCondition').value = condition;
            
            // Seleccionar el Set correcto
            if(setId) {
                document.getElementById('modalSet').value = setId;
            }

            // 2. ACTUALIZAMOS LA RUTA AL CONTROLADOR DE LISTINGS
            const form = document.getElementById('editForm');
            form.action = '/listings/' + id; 

            // 3. Mostrar modal
            const modal = document.getElementById('editModal');
            modal.classList.add('active');
            
            // 4. Gestión de foco
            setTimeout(() => {
                const closeBtn = modal.querySelector('.close-modal-btn');
                if(closeBtn) closeBtn.focus();
            }, 100);
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            if (lastFocusedElement) lastFocusedElement.focus();
        }

        // Cerrar al hacer clic fuera
        document.getElementById('editModal').addEventListener('click', function(e) {
            if(e.target === this) closeEditModal();
        });
        
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('editModal').classList.contains('active')) {
                closeEditModal();
            }
        });