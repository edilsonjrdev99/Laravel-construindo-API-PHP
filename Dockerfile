# Dockerfile
FROM php:8.2-cli

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
