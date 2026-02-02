// --- LÓGICA DEL MENÚ ---
function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeBtn');

    const isActive = sidebar.classList.toggle('active');
    overlay.classList.toggle('active');

    if (isActive) {
        setTimeout(() => { closeBtn.focus(); }, 300);
    } else {
        menuBtn.focus();
    }
}

// --- LÓGICA DE USUARIO / LOGIN ---
function checkLoginStatus() {
    const token = sessionStorage.getItem('auth_token') || localStorage.getItem('auth_token');
    let storedUser = sessionStorage.getItem('user_data') || localStorage.getItem('user_data');
    
    const authContainer = document.getElementById('auth-container');
    const linkSidebar = document.getElementById('link-perfil-sidebar');

    if (token && authContainer) {
        let userData = { name: 'Usuario' };
        try { if (storedUser) userData = JSON.parse(storedUser); } catch (e) {}

        const userName = userData.name ? userData.name.split(' ')[0] : 'Perfil';
        
        authContainer.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                    <div class="profile-avatar"><i class="fas fa-user"></i></div>
                    <span class="profile-name">${userName}</span>
                </a>
            </div>
        `;
        if(linkSidebar) {
            linkSidebar.innerHTML = `Hola, ${userName}`;
            linkSidebar.href = "/dashboard";
        }
    } else if (authContainer) {
        authContainer.innerHTML = `
            <a href="/login" class="btn-header btn-login">Login</a>
            <a href="/register" class="btn-header btn-register">Registro</a>
        `;
    }
}

// --- LÓGICA DE CARTA, SCRYFALL Y CARRITO ---
const API_URL = 'http://localhost:8000/api'; 
const params = new URLSearchParams(window.location.search);
const cardId = params.get('id');

let currentCardInfo = {}; 
let sellersData = []; 

async function init() {
    checkLoginStatus();
    updateCartCount();
    if(!cardId) return;

    // 1. Info Scryfall
    try {
        const res = await fetch(`https://api.scryfall.com/cards/${cardId}`);
        const card = await res.json();
        
        let img = "https://via.placeholder.com/400";
        if(card.image_uris) img = card.image_uris.large;
        else if(card.card_faces) img = card.card_faces[0].image_uris.large;

        currentCardInfo = { 
            name: card.name, 
            image: img, 
            rarity: card.rarity,
            set_name: card.set_name 
        };
        
        document.getElementById('main-content').innerHTML = `
            <div style="text-align:center;">
                <img src="${img}" class="card-image-large" alt="${card.name}">
            </div>
            <div>
                <h1 style="font-size:2rem; margin-bottom:10px; line-height: 1.2; font-weight: 800; color: var(--text-dark);">${card.name}</h1>
                <p style="color:var(--secondary); font-weight:600; margin-bottom: 20px; font-size: 1.1rem;">${card.type_line}</p>
                <div style="background:#f8f9fa; padding:25px; border-radius:12px; line-height: 1.6; font-size: 1rem; border: 1px solid #eee;">
                    ${card.oracle_text ? card.oracle_text.replace(/\n/g, '<br>') : 'Sin descripción disponible.'}
                </div>
            </div>
        `;
    } catch(e) { console.error("Error Scryfall:", e); }

    // 2. Info Vendedores (Backend)
    try {
        const res = await fetch(`${API_URL}/listings/card/${cardId}`);
        if(res.ok) {
            sellersData = await res.json();
            renderSellersTable(sellersData);
        } else {
            document.getElementById('sellers-tbody').innerHTML = 
                `<tr><td colspan="5" style="text-align:center; padding:30px;">No hay ofertas disponibles actualmente.</td></tr>`;
        }
    } catch(e) { console.error("Error Backend:", e); }
}

function renderSellersTable(listings) {
    const tbody = document.getElementById('sellers-tbody');
    if(listings.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding: 30px;">No hay vendedores para esta carta aún.</td></tr>`;
        return;
    }

    tbody.innerHTML = listings.map((venta, index) => {
        let editionName = currentCardInfo.set_name; 
        if (venta.card && venta.card.set && venta.card.set.name) editionName = venta.card.set.name;
        else if (venta.set_name) editionName = venta.set_name;

        return `
        <tr draggable="true" ondragstart="handleDragStart(event, ${index})">
            <td data-label="Vendedor">
                <div style="display:flex; align-items:center; gap:10px; justify-content: flex-end;">
                    <div style="text-align:right;">
                        <strong style="color: var(--primary-dark);">${venta.user ? venta.user.name : 'Vendedor'}</strong>
                        <div style="font-size:0.75rem; color:#888;">ID: ${venta.user_id}</div>
                    </div>
                    <i class="fas fa-user-circle" style="font-size:1.8rem; color:#ccc;"></i>
                </div>
            </td>
            <td data-label="Estado">
                <div>
                    <span style="font-weight:bold; margin-right:5px;">${venta.condition}</span>
                    ${venta.is_foil ? '<span class="badge badge-foil">Foil</span>' : '<span class="badge badge-normal">Normal</span>'}
                </div>
            </td>
            <td data-label="Edición">${editionName}</td>
            <td data-label="Precio" class="price-tag">${parseFloat(venta.price).toFixed(2)} €</td>
            <td>
                <button class="btn-add" onclick="manualAdd(${index})" title="Añadir al carrito">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
        </tr>
    `}).join('');
}

// --- DRAG AND DROP ---
function handleDragStart(e, index) {
    if(window.innerWidth < 769) { e.preventDefault(); return; }
    e.target.classList.add('dragging'); 
    e.dataTransfer.setData("text/plain", index);
    e.dataTransfer.effectAllowed = "copy";
}
document.addEventListener("dragend", (e) => {
    if (e.target.tagName === 'TR') e.target.classList.remove('dragging');
});
const dropZone = document.getElementById('drop-zone');
if(dropZone){
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('drag-over-active'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over-active'));
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault(); dropZone.classList.remove('drag-over-active');
        const index = e.dataTransfer.getData("text/plain");
        if(index !== "") addToCart(index);
    });
}

// --- CARRITO ---
function manualAdd(index) { addToCart(index); }

function addToCart(index) {
    const token = sessionStorage.getItem('auth_token') || localStorage.getItem('auth_token');
    
    if (!token) {
        if (confirm("🔒 Para añadir al carrito necesitas iniciar sesión. ¿Ir al login?")) {
            window.location.href = '/login'; 
        }
        return;
    }

    const venta = sellersData[index];
    let finalSet = currentCardInfo.set_name;
    if(venta.card && venta.card.set) finalSet = venta.card.set.name;

    const item = {
        id: venta.id,
        scryfall_id: cardId,
        name: currentCardInfo.name,
        image: currentCardInfo.image,
        price: parseFloat(venta.price),
        seller: venta.user ? venta.user.name : 'Desconocido',
        condition: venta.condition,
        is_foil: venta.is_foil,
        set_name: finalSet,
        addedAt: new Date().getTime()
    };

    let cart = JSON.parse(localStorage.getItem('myCart')) || [];
    if(cart.find(i => i.id === item.id)) {
        alert("⚠️ Esta oferta específica ya está en tu carrito.");
        return;
    }
    cart.push(item);
    localStorage.setItem('myCart', JSON.stringify(cart));

    const dz = document.getElementById('drop-zone');
    if(dz) {
        dz.classList.add('pop-anim');
        setTimeout(() => dz.classList.remove('pop-anim'), 300);
    }
    updateCartCount();
    
    const btn = document.querySelectorAll('.btn-add')[index];
    const oldContent = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check"></i>';
    btn.style.background = '#10b981';
    setTimeout(() => {
        btn.innerHTML = oldContent;
        btn.style.background = 'var(--text-dark)';
    }, 1500);
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('myCart')) || [];
    const countEl = document.getElementById('cart-count');
    if(countEl) countEl.innerText = cart.length;
}

window.onload = init;
window.addEventListener('pageshow', updateCartCount);
window.addEventListener('storage', (e) => { if (e.key === 'myCart') updateCartCount(); });