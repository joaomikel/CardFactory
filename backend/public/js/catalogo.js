/* --- GESTIÓN VISUAL --- */
        let lastFocusedElement;
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
        function openAccModal() { document.getElementById('acc-modal').classList.add('active'); document.body.style.overflow = 'hidden'; }
        function closeAccModal() { document.getElementById('acc-modal').classList.remove('active'); document.body.style.overflow = ''; }

        /* --- LOGIN STATUS (ACTUALIZADO IGUAL QUE TU EJEMPLO) --- */
        function checkLoginStatus() {
            const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
            const authContainer = document.getElementById('auth-container');
            const footerLoginLink = document.getElementById('footer-login-link');
            const linkSidebar = document.getElementById('link-perfil-sidebar');
            
            let userData = { name: 'Usuario' };
            try {
                const storedUser = localStorage.getItem('user_data') || sessionStorage.getItem('user_data');
                if (storedUser) userData = JSON.parse(storedUser);
            } catch (e) { }

            if (token) {
                const userName = userData.name ? userData.name.split(' ')[0] : 'Perfil';
                
                // Actualizar Header
                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                            <div class="profile-avatar"><i class="fas fa-user"></i></div>
                            <span class="profile-name">${userName}</span>
                        </a>`;
                }
                // Actualizar Sidebar
                if (linkSidebar) {
                    linkSidebar.innerHTML = `Hola, ${userName}`;
                    linkSidebar.href = "/dashboard";
                }
                // Actualizar Footer
                if (footerLoginLink) {
                    footerLoginLink.textContent = "Mi Perfil";
                    footerLoginLink.href = "/dashboard";
                }
            }
        }

        /* --- LÓGICA DE STOCK Y PRECIOS --- */
        async function checkLocalStock(scryfallIds) {
            try {
                // NOTA: Usamos la ruta /api/check-stock que pusimos en api.php
                const response = await fetch('/api/check-stock', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids: scryfallIds })
                });

                if (!response.ok) return {};
                return await response.json();
            } catch (error) {
                console.error("Error comprobando stock:", error);
                return {}; 
            }
        }

        async function fetchCards(q = 'f:standard') {
            const grid = document.getElementById('catalog-grid');
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 50px; font-size:1.2rem;"><i class="fas fa-circle-notch fa-spin"></i> Buscando cartas...</p>';

            try {
                const res = await fetch(`https://api.scryfall.com/cards/search?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                
                if(!data.data || data.data.length === 0) {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 30px;">No se encontraron cartas.</p>';
                    return;
                }

                const scryfallIds = data.data.map(card => card.id);
                const stockMap = await checkLocalStock(scryfallIds);

                grid.innerHTML = data.data.map(card => {
                    let imgUrl = 'https://via.placeholder.com/488x680';
                    if (card.image_uris && card.image_uris.normal) {
                        imgUrl = card.image_uris.normal;
                    } else if (card.card_faces && card.card_faces[0].image_uris) {
                        imgUrl = card.card_faces[0].image_uris.normal;
                    }

                    const dbPrice = stockMap[card.id]; 
                    let priceHtml;
                    
                    if (dbPrice !== undefined && dbPrice !== null) {
                        priceHtml = `<span style="color: var(--primary); font-weight: 800;">${parseFloat(dbPrice).toFixed(2)}€</span>`;
                    } else {
                        priceHtml = `<span style="color: #999; font-weight: 600; font-size: 0.9rem;">No Stock</span>`;
                    }

                    return `
                        <a href="/carta?id=${card.id}" class="card-catalog" tabindex="0">
                            <img src="${imgUrl}" alt="Carta: ${card.name}" loading="lazy">
                            <div class="card-info">
                                <h3>${card.name}</h3>
                                <div class="card-price">${priceHtml}</div>
                            </div>
                        </a>
                    `;
                }).join('');

            } catch (e) { 
                console.error(e);
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: red;">Error de conexión.</p>'; 
            }
        }

        function applyFilters() {
            const name = document.getElementById('search-name').value;
            const color = document.getElementById('color').value;
            const rarity = document.getElementById('rarity').value;
            const set = document.getElementById('set').value;
            
            let queryParts = [];
            if (name) queryParts.push(`name:"${name}"`);
            else if (name && !name.includes('"')) queryParts.push(`name:${name}`);
            if (color) queryParts.push(`c:${color}`);
            if (rarity) queryParts.push(`r:${rarity}`);
            if (set) queryParts.push(`s:${set}`);
            
            const finalQuery = queryParts.length > 0 ? queryParts.join(' ') : 'f:standard';
            fetchCards(finalQuery);
        }

        document.addEventListener('DOMContentLoaded', () => {
            checkLoginStatus(); // Ejecutamos la comprobación de login
            
            const params = new URLSearchParams(window.location.search);
            const nameFromUrl = params.get('name');
            const setFromUrl = params.get('set');

            if (nameFromUrl) {
                document.getElementById('search-name').value = nameFromUrl;
                fetchCards(`name:${nameFromUrl}`);
            } else if (setFromUrl) {
                document.getElementById('set').value = setFromUrl;
                fetchCards(`s:${setFromUrl}`);
            } else {
                fetchCards();
            }

            document.getElementById('search-name').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') applyFilters();
            });
        });