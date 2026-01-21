<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Mi Carrito</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8C52FF; 
            --bg: #F5F7FA;
            --dark: #1F2937;
        }
        * { box-sizing: border-box; font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        
        body { background: var(--bg); padding-bottom: 180px; }

        header {
            background: white; padding: 20px;
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .back-btn { font-size: 1.2rem; margin-right: 15px; cursor: pointer; color: var(--dark); text-decoration: none;}
        h1 { font-size: 1.2rem; font-weight: 800; color: var(--dark); }

        .container { max-width: 600px; margin: 0 auto; padding: 20px; }

        /* Tarjeta del producto */
        .cart-item {
            background: white;
            border-radius: 16px;
            padding: 12px;
            display: flex; align-items: center; gap: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
        }
        
        .item-img {
            width: 70px; height: 100px; /* Proporción carta magic */
            object-fit: cover;
            border-radius: 8px;
            background: #eee;
        }

        .item-info { flex: 1; }
        .item-title { font-weight: 700; font-size: 1rem; color: var(--dark); margin-bottom: 4px; }
        .item-price { color: var(--primary); font-weight: 700; font-size: 1.1rem; }
        .item-meta { font-size: 0.8rem; color: #888; text-transform: capitalize; margin-top: 2px; }

        .btn-delete {
            background: #fee2e2; color: #ef4444;
            border: none; width: 35px; height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }
        .btn-delete:hover { background: #fecaca; transform: scale(1.1); }

        /* Footer Fijo */
        .cart-footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: white;
            padding: 25px;
            border-top-left-radius: 25px; border-top-right-radius: 25px;
            box-shadow: 0 -5px 30px rgba(0,0,0,0.1);
            max-width: 600px; margin: 0 auto;
        }

        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #666; }
        .total-row { display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 20px; font-weight: 800; font-size: 1.3rem; color: var(--dark); }
        
        .checkout-btn {
            background: var(--primary); color: white;
            width: 100%; border: none; padding: 16px;
            border-radius: 14px; font-size: 1rem; font-weight: 700;
            cursor: pointer; box-shadow: 0 5px 20px rgba(140, 82, 255, 0.4);
            transition: 0.2s;
        }
        .checkout-btn:active { transform: scale(0.98); }

        /* Animación para cuando borras */
        .fade-out { opacity: 0; transform: translateX(100%); transition: all 0.3s ease; }
    </style>
</head>
<body>

    <header>
        <a href="javascript:history.back()" class="back-btn"><i class="fas fa-arrow-left"></i></a>
        <h1>Carrito de Compra</h1>
    </header>

    <div class="container" id="cart-items">
        </div>

    <div class="cart-footer">
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="subtotal">0.00 €</span>
        </div>
        <div class="summary-row">
            <span>Envío (Fijo)</span>
            <span id="shipping">0.00 €</span>
        </div>
        <div class="total-row">
            <span>Total</span>
            <span style="color: var(--primary);" id="total">0.00 €</span>
        </div>
        <button class="checkout-btn" onclick="checkout()">Finalizar Compra</button>
    </div>

    <script>
        // --- LÓGICA 100% SIN LOGIN ---
        
        // 1. Cargamos lo que guardó el Drag & Drop
        let cart = JSON.parse(localStorage.getItem('myCart')) || [];
        const shippingCost = 5.00;

        function renderCart() {
            const container = document.getElementById('cart-items');
            
            // Si está vacío
            if (cart.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; margin-top: 60px;">
                        <i class="fas fa-shopping-basket" style="font-size: 4rem; color: #ddd;"></i>
                        <p style="margin-top: 20px; color: #888;">Tu carrito está vacío.</p>
                        <p style="font-size: 0.9rem; color: #aaa;">Arrastra cartas aquí para comprar.</p>
                    </div>`;
                updateTotals(0);
                return;
            }

            // Pintar items
            container.innerHTML = cart.map((item, index) => `
                <div class="cart-item" id="item-${index}">
                    <img src="${item.image}" class="item-img" onerror="this.src='https://via.placeholder.com/70'">
                    <div class="item-info">
                        <div class="item-title">${item.name}</div>
                        <div class="item-price">${item.price.toFixed(2)} €</div>
                        <div class="item-meta">
                            ${item.rarity || 'Carta'} • ${item.condition || 'NM'}
                        </div>
                    </div>
                    <button class="btn-delete" onclick="removeItem(${index})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `).join('');

            // Calcular
            const subtotal = cart.reduce((sum, item) => sum + item.price, 0);
            updateTotals(subtotal);
        }

        function updateTotals(subtotal) {
            const ship = subtotal > 0 ? shippingCost : 0;
            const total = subtotal + ship;

            document.getElementById('subtotal').innerText = subtotal.toFixed(2) + ' €';
            document.getElementById('shipping').innerText = ship.toFixed(2) + ' €';
            document.getElementById('total').innerText = total.toFixed(2) + ' €';
        }

        function removeItem(index) {
            const row = document.getElementById(`item-${index}`);
            row.classList.add('fade-out');

            setTimeout(() => {
                cart.splice(index, 1);
                localStorage.setItem('myCart', JSON.stringify(cart));
                renderCart();
            }, 300);
        }

        function checkout() {
            // 1. Validación básica: Carrito vacío
            if(cart.length === 0) return alert("El carrito está vacío.");
            
            // --- NUEVA LÓGICA DE LOGIN ---
            // Intentamos recuperar el token o dato que indica que está logueado.
            // (Asegúrate de que tu Login guarde esto como 'auth_token' o similar)
            const token = localStorage.getItem('auth_token'); 

            // Si NO hay token (es null), es que no está logueado
            if (!token) {
                // Opcional: Avisar al usuario
                alert("🔒 Para finalizar la compra necesitas iniciar sesión.");
                
                // REDIRECCIÓN: Aquí pones la dirección de tu Login de Laravel
                // Si tu backend está en el puerto 8000, suele ser esta:
                window.location.href = 'http://localhost:8000/login'; 
                
                return; // ¡Importante! Esto detiene la función para que no siga comprando.
            }
            // -----------------------------

            // 2. Si llegamos aquí, es que SÍ está logueado. Procedemos.
            // Aquí en el futuro harías un fetch() a tu API para guardar el pedido real.
            
            if(confirm(`¿Confirmar compra por ${document.getElementById('total').innerText}?`)) {
                
                // Aquí podrías enviar los datos al backend si quisieras:
                // enviarPedidoAlBackend(cart, token);

                alert("¡Compra realizada con éxito! 📦\n(Usuario verificado)");
                
                // Vaciar carrito
                cart = [];
                localStorage.removeItem('myCart');
                renderCart();
            }
        }

        // Iniciar
        renderCart();
    </script>
</body>
</html>