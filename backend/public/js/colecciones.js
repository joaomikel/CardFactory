function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeSidebarBtn');

    const isActive = sidebar.classList.toggle('active');
    overlay.classList.toggle('active');

    if (isActive) {
        setTimeout(() => closeBtn.focus(), 300);
    } else {
        menuBtn.focus();
    }
}

// Sustituye tu función checkLoginStatus antigua por esta:
            function checkLoginStatus() {
                // 1. Buscamos el token
                const token = sessionStorage.getItem('auth_token') || localStorage.getItem('auth_token');
                
                // 2. Buscamos los datos "viejos" (caché) para mostrar algo rápido
                let storedUser = sessionStorage.getItem('user_data') || localStorage.getItem('user_data');
                let userData = { name: 'Usuario' };

                try {
                    if (storedUser) userData = JSON.parse(storedUser);
                } catch (e) {
                    console.error("Error parseando usuario", e);
                }

                if (token) {
                    // --- A. MOSTRAR DATOS DE LA CACHÉ (Inmediato) ---
                    updateUserUI(userData);

                    // --- B. PEDIR DATOS FRESCOS AL SERVIDOR (Segundo plano) ---
                    // Esto arregla tu problema: actualiza el nombre si cambió en la DB
                    fetch('/api/user', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) return response.json();
                        throw new Error('Sesión expirada o inválida');
                    })
                    .then(freshUser => {
                        // Si el nombre ha cambiado, actualizamos todo
                        if (JSON.stringify(freshUser) !== storedUser) {
                            console.log("Datos actualizados desde el servidor");
                            
                            // 1. Guardar en memoria nueva
                            localStorage.setItem('user_data', JSON.stringify(freshUser));
                            sessionStorage.setItem('user_data', JSON.stringify(freshUser));
                            
                            // 2. Actualizar el Header otra vez con el nombre nuevo
                            updateUserUI(freshUser);
                        }
                    })
                    .catch(error => {
                        console.error("Error verificando sesión:", error);
                        // Opcional: Si el token no vale, cerrar sesión
                        // logout(); 
                    });

                } else {
                    // --- USUARIO NO LOGUEADO ---
                    showGuestUI();
                }
            }

            // --- FUNCIONES AUXILIARES PARA LIMPIAR EL CÓDIGO ---

            function updateUserUI(user) {
                const userName = user.name ? user.name.split(' ')[0] : 'Mi Cuenta';
                const authContainer = document.getElementById('auth-container');
                const linkSidebar = document.getElementById('link-perfil-sidebar');
                const footerLoginLink = document.getElementById('footer-login-link');

                // 1. Header
                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                            <div class="profile-avatar"><i class="fas fa-user"></i></div>
                            <span class="profile-name">${userName}</span>
                        </a>`;
                }
                // 2. Sidebar
                if (linkSidebar) {
                    linkSidebar.innerHTML = `Hola, ${userName}`;
                    linkSidebar.href = "/dashboard";
                    linkSidebar.style.color = "var(--primary)";
                    linkSidebar.style.fontWeight = "bold";
                }
                // 3. Footer
                if (footerLoginLink) {
                    footerLoginLink.textContent = "Mi Perfil";
                    footerLoginLink.href = "/dashboard";
                }
            }

            function showGuestUI() {
                const authContainer = document.getElementById('auth-container');
                const linkSidebar = document.getElementById('link-perfil-sidebar');
                const footerLoginLink = document.getElementById('footer-login-link');

                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/login" class="btn-header btn-login">Login</a>
                        <a href="/register" class="btn-header btn-register">Registro</a>`;
                }
                if (linkSidebar) {
                    linkSidebar.textContent = "Login";
                    linkSidebar.href = "/login";
                    linkSidebar.style.color = "";
                }
                if (footerLoginLink) {
                    footerLoginLink.textContent = "Acceso Login";
                    footerLoginLink.href = "/login";
                }
            }


let allSets = [];
let currentCount = 20;

async function loadSets() {
    const container = document.getElementById('sets-container');
    try {
        const res = await fetch('https://api.scryfall.com/sets');
        const data = await res.json();
        const validTypes = ['expansion', 'core', 'masters', 'draft_innovation', 'commander', 'modern'];
        allSets = data.data.filter(set => validTypes.includes(set.set_type));
        allSets.sort((a, b) => new Date(b.released_at) - new Date(a.released_at));
        renderSets(allSets.slice(0, currentCount));
    } catch (error) {
        container.innerHTML = '<p>Error de conexión.</p>';
    }
}

function renderSets(setsList) {
    const container = document.getElementById('sets-container');
    if(setsList.length === 0) {
        container.innerHTML = '<p style="text-align:center; padding:20px;">No hay resultados.</p>';
        return;
    }
    container.innerHTML = setsList.map(set => `
        <div class="set-item" tabindex="0" onclick="window.location.href='/catalogo?set=${set.code}'" onkeypress="if(event.key==='Enter')window.location.href='/catalogo?set=${set.code}'">
            <img src="${set.icon_svg_uri}" class="set-icon" alt="" loading="lazy">
            <div class="set-info">
                <h3>${set.name}</h3>
                <p>${set.card_count} Cartas • ${new Date(set.released_at).getFullYear()}</p>
            </div>
            <div class="arrow-indicator">›</div>
        </div>
    `).join('');
}

const searchInput = document.getElementById('setSearchInput');
if(searchInput) {
    searchInput.addEventListener('keyup', (e) => {
        const term = e.target.value.toLowerCase();
        const filtered = allSets.filter(set => set.name.toLowerCase().includes(term));
        renderSets(filtered.slice(0, 20));
        const loadMore = document.getElementById('loadMoreBtn');
        if(loadMore) loadMore.style.display = (term !== '' || filtered.length <= 20) ? 'none' : 'block';
    });
}

const loadMoreBtn = document.getElementById('loadMoreBtn');
if(loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => {
        currentCount += 20;
        renderSets(allSets.slice(0, currentCount));
        if (currentCount >= allSets.length) loadMoreBtn.style.display = 'none';
    });
}

let lastFocusedElement;
function openAccModal() {
    lastFocusedElement = document.activeElement;
    const modal = document.getElementById('acc-modal');
    modal.classList.add('active');
    setTimeout(() => { modal.querySelector('.modal-close').focus(); }, 100);
    document.body.style.overflow = 'hidden';
}

function closeAccModal() {
    document.getElementById('acc-modal').classList.remove('active');
    document.body.style.overflow = '';
    if (lastFocusedElement) lastFocusedElement.focus();
}

document.addEventListener("DOMContentLoaded", () => {
    checkLoginStatus(); 
    loadSets(); 
});