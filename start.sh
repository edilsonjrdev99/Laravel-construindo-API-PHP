#!/bin/bash

set -e

echo "Iniciando aplicação Laravel..."

# Aguardar banco de dados estar disponível (se necessário)
if [ ! -z "$DB_HOST" ]; then
    echo "Aguardando banco de dados..."
    until nc -z -v -w30 $DB_HOST ${DB_PORT:-3306}; do
        echo "Aguardando conexão com o banco de dados..."
        sleep 2
    done
    echo "Banco de dados disponível!"
fi

# Rodar migrations (comente se preferir rodar manualmente)
echo "Rodando migrations..."
php artisan migrate --force || echo "Migrations falharam ou já foram executadas"

# Otimizações do Laravel para produção
echo "Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Garantir permissões corretas
echo "Configurando permissões..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Iniciar PHP-FPM em background
echo "Iniciando PHP-FPM..."
php-fpm -D

# Iniciar Nginx em foreground
echo "Iniciando Nginx..."
nginx -g 'daemon off;'
