# --- Stage 1: Node.js for frontend assets ---
FROM node:18-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Stage 2: PHP with Composer for backend ---
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Install system dependencies and PHP extensions if needed
RUN apk add --no-cache bash git unzip openssh-client

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy compiled frontend assets from Stage 1
COPY --from=frontend-builder /app/public /var/www/html/public

# Run Composer installation
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

FROM php:8.4-fpm-alpine

# Added git, unzip, and openssh to support all Composer downloads
RUN apk add --no-cache nginx supervisor mariadb-client postgresql-dev libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev git unzip openssh

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd zip bcmath

WORKDIR /var/www/html

COPY . .

# Added --ignore-platform-reqs to prevent local PHP/extension mismatches from blocking the container build
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && nginx && php-fpm"]
