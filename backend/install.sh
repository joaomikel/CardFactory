#!/bin/bash

# Imprimir mensaje de inicio
echo "🚀 Iniciando instalación de CardFactory (Docker + Ubuntu)..."

# 1. Configuración del entorno del Backend (Laravel)
echo "📄 Configurando entorno de Laravel..."
# Verificamos si existe la carpeta backend
if [ -d "./backend" ]; then
    # Copiamos el .env dentro de la carpeta backend
    if [ ! -f ./backend/.env ]; then
        cp ./backend/.env.example ./backend/.env
        echo "✅ Archivo .env creado en /backend."
    else
        echo "ℹ️ El archivo .env ya existía en /backend."
    fi
else
    echo "❌ ERROR: No encuentro la carpeta 'backend'. ¿Estás en la raíz del proyecto?"
    exit 1
fi

# 2. Ajustar permisos de carpetas ANTES de arrancar (para evitar errores de escritura)
echo "🔒 Ajustando permisos de almacenamiento..."
chmod -R 777 backend/storage backend/bootstrap/cache

# 3. Levantar Docker
echo "🐳 Construyendo y levantando contenedores..."
# Usamos --build para asegurar que toma los cambios del código
docker compose up -d --build

# 4. Esperar a que la Base de Datos arranque
# MySQL tarda unos segundos en estar listo. Si intentamos migrar ya, fallará.
echo "⏳ Esperando 15 segundos a que MySQL arranque..."
sleep 15

# 5. Instalar dependencias de PHP (Composer)
echo "📦 Instalando dependencias de Composer (esto puede tardar)..."
docker compose exec backend composer install --no-interaction

# 6. Generar la clave de encriptación
echo "🔑 Generando Key de la aplicación..."
docker compose exec backend php artisan key:generate

# 7. Ejecutar migraciones y seeds
echo "🗄️ Migrando base de datos y sembrando datos..."
# Nota: Usamos 'force' porque en producción a veces pide confirmación
docker compose exec backend php artisan migrate:fresh --seed --force

echo "✅ ¡Instalación completada con éxito!"
echo "🌍 Tu web debería estar visible en: http://localhost (o tu IP pública)"
echo "🛠️ Tu API está en el puerto 8000 y PHPMyAdmin en el puerto 8080"