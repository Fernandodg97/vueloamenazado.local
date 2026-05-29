#!/bin/bash
set -e

# Deshabilitar MPMs conflictivos
a2dismod mpm_event mpm_worker 2>/dev/null || true

# Usar el puerto que Railway inyecta via $PORT (por defecto 80)
LISTEN_PORT=${PORT:-80}

echo "Configurando Apache en puerto $LISTEN_PORT"

# Cambiar puerto en ports.conf
sed -i "s/Listen 80/Listen $LISTEN_PORT/g" /etc/apache2/ports.conf

# Cambiar puerto en el VirtualHost
sed -i "s/*:80>/*:$LISTEN_PORT>/g" /etc/apache2/sites-enabled/000-default.conf

# Arrancar Apache
exec apache2-foreground
