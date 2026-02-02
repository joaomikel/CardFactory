/* Ubicación: public/js/catalogo.js */

/* --- GESTIÓN DE FOCO Y ACCESIBILIDAD --- */
let lastFocusedElement;

function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeSidebarBtn');

    const isActive = sidebar.classList.toggle('active');
    overlay.classList.toggle('active');

    if (isActive) {
        lastFocusedElement = document.activeElement;
        setTimeout(() => closeBtn.focus(), 300);
    } else {
        if(menuBtn) menuBtn.focus();
    }
}

/* --- MODAL ACCESIBILIDAD --- */
function openAccModal() {
    lastFocusedElement = document.activeElement;
    const modal = document.getElementById('acc-modal');
    modal.classList.add('active');
    
    // Focus trap simple
    setTimeout(() => { modal.querySelector('.modal-close').focus(); }, 100);
    document.body.style.overflow = 'hidden'; // Bloquear scroll
}

function closeAccModal() {
    document.getElementById('acc-modal').classList.remove('active');
    document.body.style.overflow = ''; 
    if (lastFocusedElement) lastFocusedElement.focus();
}

/* --- LÓGICA DE USUARIO --- */
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
        if (authContainer) {
            authContainer.innerHTML = `
                <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                    <div class="profile-avatar"><i class="fas fa-user"></i></div>
                    <span class="profile-name">${userName}</span>
                </a>`;
        }
        if (linkSidebar) {
            linkSidebar.innerHTML = `Hola, ${userName}`;
            linkSidebar.href = "/dashboard";
        }
        if (footerLoginLink) {
            footerLoginLink.textContent = "Mi Perfil";
            footerLoginLink.href = "/dashboard";
        }
    }
}

/* --- API Y CATÁLOGO --- */
async function checkLocalStock(scryfallIds) {
    try {
        return {}; 
    } catch (error) { return {}; }
}

async function fetchCards(q = 'f:standard') {
    const grid = document.getElementById('catalog-grid');
    if(!grid) return;
    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 50px;"><i class="fas fa-circle-notch fa-spin"></i> Cargando cartas...</p>';

    try {
        const res = await fetch(`https://api.scryfall.com/cards/search?q=${encodeURIComponent(q)}`);
        const data = await res.json();
        
        if(!data.data || data.data.length === 0) {
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">No se encontraron cartas.</p>';
            return;
        }

        grid.innerHTML = data.data.map(card => {
            let imgUrl = 'https://via.placeholder.com/488x680';
            if (card.image_uris && card.image_uris.normal) {
                imgUrl = card.image_uris.normal;
            } else if (card.card_faces && card.card_faces[0].image_uris) {
                imgUrl = card.card_faces[0].image_uris.normal;
            }

            const price = card.prices?.eur ? `${card.prices.eur}€` : 'N/A';

            return `
                <a href="/carta?id=${card.id}" class="card-catalog" tabindex="0">
                    <img src="${imgUrl}" alt="Carta: ${card.name}" loading="lazy">
                    <div class="card-info">
                        <h3>${card.name}</h3>
                        <p class="card-price">${price}</p>
                    </div>
                </a>
            `;
        }).join('');
    } catch (e) { 
        console.error(e);
        grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">Error de conexión con la base de datos.</p>'; 
    }
}

function applyFilters() {
    const name = document.getElementById('search-name').value;
    const color = document.getElementById('color').value;
    const rarity = document.getElementById('rarity').value;
    const set = document.getElementById('set').value;
    
    let queryParts = [];
    
    if (name) queryParts.push(`name:${name}`);
    if (color) queryParts.push(`c:${color}`);
    if (rarity) queryParts.push(`r:${rarity}`);
    if (set) queryParts.push(`s:${set}`);
    
    const finalQuery = queryParts.length > 0 ? queryParts.join(' ') : 'f:standard';
    fetchCards(finalQuery);
}

/* --- INICIALIZACIÓN --- */
document.addEventListener('DOMContentLoaded', () => {
    checkLoginStatus();
    
    const params = new URLSearchParams(window.location.search);
    const setCode = params.get('set');
    
    if (setCode) {
        const setSelect = document.getElementById('set');
        if(setSelect) {
            setSelect.value = setCode;
            fetchCards(`s:${setCode}`);
        }
    } else {
        fetchCards(); 
    }

    const searchInput = document.getElementById('search-name');
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') applyFilters();
        });
    }
});