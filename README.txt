# 🃏 CardFactory - Marketplace de Magic: The Gathering

CardFactory es una plataforma web moderna para la compra, venta y gestión de cartas coleccionables de *Magic: The Gathering*. El proyecto integra datos en tiempo real de la API de Scryfall con un sistema de gestión de stock local, priorizando una experiencia de usuario fluida y accesible.

-----------------------------------------

## Características Principales

-   Catálogo Dinámico: Sincronización con Scryfall API para obtener imágenes y datos actualizados de cartas.
-   Gestión de Stock Local: Sistema híbrido que verifica disponibilidad y precios personalizados (`stockMap`) sobre los datos de la API.
-   Filtros Avanzados: Búsqueda por nombre, color, rareza y colección (Set).
-   Interfaz Reactiva: Diseño Mobile-First con animaciones CSS fluidas (efecto cascada) y Grid Layout.
-   Accesibilidad (A11y):
    -   Cumplimiento de contrastes de color (WCAG AA).
    -   Navegación por teclado y soporte para lectores de pantalla (ARIA labels).
    -   Modo de alto contraste y etiquetas semánticas.
-   Autenticación: Sistema de Login y Registro de usuarios.
-   Panel de Administración: (En desarrollo) Gestión de inventario visual mediante phpMyAdmin.

-----------------------------------------

## 🛠️ Tecnologías Utilizadas

### Frontend
-   HTML5 / Blade Templates: Estructura semántica.
-   CSS3: Variables CSS (`:root`), Flexbox, CSS Grid, y animaciones `@keyframes`.
-   JavaScript (ES6+): `fetch` API, manipulación del DOM y lógica asíncrona (`async/await`).
-   FontAwesome: Iconografía (optimizada con `aria-hidden` para accesibilidad).

### Backend
-   PHP / Laravel: Framework principal (Rutas, Controladores, CSRF protection).
-   MySQL: Base de datos relacional para usuarios, stock y pedidos.

### APIs Externas
-   Scryfall API:(https://scryfall.com/docs/api): Fuente de datos de las cartas.

-----------------------------------------

## 🚀 Instalación y Configuración

Sigue estos pasos para levantar el proyecto en tu entorno local:

### Prerrequisitos
-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   MySQL

### Pasos
1.  Clonar el repositorio:
    ```bash
    git clone [https://github.com/tu-usuario/cardfactory.git](https://github.com/tu-usuario/cardfactory.git)
    cd cardfactory
    ```

2.  Instalar dependencias de PHP:
    ```bash
    composer install
    ```

3.  Configurar entorno:
    Duplica el archivo `.env.example` y renómbralo a `.env`. Configura tu base de datos:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=cardfactory
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  Generar Key de aplicación:
    ```bash
    php artisan key:generate
    ```

5.  Ejecutar migraciones (Base de datos):
    ```bash
    php artisan migrate
    ```

6.  Iniciar servidor local:
    ```bash
    php artisan serve
    ```
    Visita `http://localhost:8000` en tu navegador.

---------------------------------------

## Estructura de Estilos y Temas

El proyecto utiliza un sistema de variables CSS para facilitar el mantenimiento y la accesibilidad.

Ubicación: public/css/catalogo.css

css:
:root {
    --primary: #6c5a96;       /
    --primary-dark: #5e4c8d;
    --secondary: #6e667a;
    --focus-ring: #ffbf00;   
    --bg: #f9f9f9;
}