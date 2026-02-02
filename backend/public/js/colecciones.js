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