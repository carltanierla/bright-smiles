# --- Stage 1: Build the frontend assets ---
FROM node:18-alpine AS frontend-builder
WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install

# Copy everything and build your assets (Vite, Webpack, Mix, etc.)
COPY . .
RUN npm run build

# --- Stage 2: Build the production PHP app ---
FROM php:8.2-apache
WORKDIR /var/www/html

# Install system utilities needed for Git/Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for modern application routing
RUN a2enmod rewrite

# Bring in Composer directly from its official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application code
COPY . .

# Copy ONLY the compiled production assets from Stage 1
# Note: Adjust "/app/public" if your framework builds to a different directory (e.g., "/app/dist")
COPY --from=frontend-builder /app/public /var/www/html/public

# Run Composer installation optimized for production
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Adjust file ownership so Apache can read and write to your directories
RUN chown -R www-data:www-data /var/www/html

# Dynamically map Apache to the port assigned by Render
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

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
