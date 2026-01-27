<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vender Carta - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #816EB2; --dark: #111827; --bg: #f3f4f6; --success: #10b981; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg); color: var(--dark); padding: 40px 20px; }
        .container { max-width: 900px; margin: 0 auto; }

        .btn-back { text-decoration: none; color: var(--primary); font-weight: 700; margin-bottom: 20px; display: inline-block; }
        
        h1 { font-weight: 800; margin-bottom: 30px; letter-spacing: -1px; }

        /* Buscador */
        .search-box { 
            background: white; padding: 10px; border-radius: 16px; 
            display: flex; gap: 10px; margin-bottom: 30px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;
        }
        input, select { padding: 12px 15px; border: 1px solid #e5e7eb; border-radius: 10px; outline: none; font-size: 1rem; }
        input[type="text"] { flex-grow: 1; }
        .btn-search { background: var(--primary); color: white; border: none; padding: 0 25px; border-radius: 10px; cursor: pointer; font-weight: 700; transition: 0.2s; }
        .btn-search:hover { opacity: 0.9; transform: translateY(-1px); }

        /* Resultados */
        .results-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .card-item { 
            background: white; padding: 12px; border-radius: 16px; text-align: center; 
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; border: 2px solid transparent;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .card-item:hover { border-color: var(--primary); transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .card-item img { width: 100%; border-radius: 10px; margin-bottom: 10px; }
        .card-item h4 { font-size: 0.85rem; font-weight: 700; color: #374151; height: 34px; overflow: hidden; }

        /* Formulario de Venta */
        #listing-form { 
            background: white; padding: 40px; border-radius: 24px; display: none; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;
            animation: slideUp 0.4s ease;
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-top: 20px; }
        label { display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; color: #4b5563; }
        
        .checkbox-container { display: flex; align-items: center; gap: 10px; cursor: pointer; margin-top: 10px; }
        .checkbox-container input { width: 20px; height: 20px; cursor: pointer; accent-color: var(--primary); }

        .btn-publish { 
            background: var(--success); color: white; border: none; padding: 18px; 
            width: 100%; border-radius: 12px; font-weight: 800; font-size: 1.1rem; 
            cursor: pointer; margin-top: 30px; transition: 0.2s;
        }
        .btn-publish:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3); }
    </style>
</head>
<body>

<div class="container">
    <a href="/dashboard" class="btn-back"><i class="fas fa-chevron-left"></i> Volver al Perfil</a>
    
    <h1><i class="fas fa-magic"></i> ¿Qué vas a vender hoy?</h1>
    
    <div class="search-box">
        <input type="text" id="card-name" placeholder="Nombre de la carta (ej: Black Lotus)...">
        <button class="btn-search" onclick="searchCards()">Buscar Carta</button>
    </div>

    <div id="results" class="results-grid"></div>

    <div id="listing-form">
        <h2 id="selected-card-name" style="letter-spacing: -0.5px; font-weight: 800;"></h2>
        <p style="color: #6b7280; margin-bottom: 25px;">Completa los detalles de tu oferta</p>
        
        <div class="form-grid">
            <input type="hidden" id="scryfall-id">
            
            <div>
                <label><i class="fas fa-euro-sign"></i> Precio de venta</label>
                <input type="number" id="price" step="0.01" placeholder="0.00" style="width: 100%">
            </div>
            
            <div>
                <label><i class="fas fa-star"></i> Estado físico</label>
                <select id="condition" style="width: 100%">
                    <option value="Mint">Mint (Perfecta)</option>
                    <option value="Near Mint">Near Mint (Casi Nueva)</option>
                    <option value="Excellent">Excellent</option>
                    <option value="Good">Good</option>
                    <option value="Played">Played (Muy usada)</option>
                </select>
            </div>

            <div class="full-width">
                <label class="checkbox-container">
                    <input type="checkbox" id="is_foil"> 
                    <span>¿Es una versión <strong>Foil</strong> (Brillante)?</span>
                </label>
            </div>
        </div>
        <button class="btn-publish" id="btnPublish" onclick="publishListing()">
            Publicar en el Mercado
        </button>
    </div>
</div>
<script>
    // URL DE TU SERVIDOR (UBUNTU)
    const API_URL = 'http://10.10.18.108:8000';

    // Función auxiliar para leer la cookie XSRF (Seguridad de Laravel)
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    async function searchCards() {
        const query = document.getElementById('card-name').value;
        if(query.length < 3) return;
        
        const btn = document.querySelector('.btn-search');
        btn.innerText = "Buscando...";
        
        try {
            const res = await fetch(`https://api.scryfall.com/cards/search?q=${query}`);
            const data = await res.json();
            
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '';
            
            if(data.data) {
                data.data.slice(0, 10).forEach(card => {
                    const img = card.image_uris ? card.image_uris.normal : (card.card_faces ? card.card_faces[0].image_uris.normal : '');
                    resultsDiv.innerHTML += `
                        <div class="card-item" onclick="selectCard('${card.id}', '${card.name.replace(/'/g, "")}')">
                            <img src="${img}">
                            <h4>${card.name}</h4>
                        </div>
                    `;
                });
            }
        } catch(e) {
            alert("Error al buscar cartas");
        } finally {
            btn.innerText = "Buscar Carta";
        }
    }

    function selectCard(id, name) {
        document.getElementById('scryfall-id').value = id;
        document.getElementById('selected-card-name').innerText = name;
        document.getElementById('listing-form').style.display = 'block';
        document.getElementById('listing-form').scrollIntoView({ behavior: 'smooth' });
    }

    async function publishListing() {
        const publishBtn = document.getElementById('btnPublish');
        const price = document.getElementById('price').value;
        
        if(!price || price <= 0) {
            alert("Por favor, introduce un precio válido.");
            return;
        }

        publishBtn.disabled = true;
        publishBtn.innerText = "Publicando...";

        const payload = {
            card_id: document.getElementById('scryfall-id').value,
            price: price,
            condition: document.getElementById('condition').value,
            is_foil: document.getElementById('is_foil').checked,
        };

        try {
            // PETICIÓN AL BACKEND CON COOKIES
            const res = await fetch(`${API_URL}/api/listings`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': getCookie('XSRF-TOKEN') // Token de seguridad
                },
                credentials: 'include', // ¡IMPORTANTE! Envía la sesión del usuario
                body: JSON.stringify(payload)
            });

            if(res.ok) {
                alert("¡Excelente! Tu carta ya está a la venta.");
                window.location.href = "/dashboard"; 
            } else {
                // Si falla (ej: 401), intentamos leer el mensaje
                const error = await res.json().catch(() => ({}));
                
                if (res.status === 401) {
                    alert("Tu sesión ha caducado. Por favor, identifícate de nuevo.");
                    window.location.href = "/login";
                } else {
                    alert("Error: " + (error.message || "No se pudo publicar."));
                }
            }
        } catch(e) {
            console.error(e);
            alert("Error de conexión con el servidor (" + API_URL + ").");
        } finally {
            publishBtn.disabled = false;
            publishBtn.innerText = "Publicar en el Mercado";
        }
    }
</script>
</body>
</html>