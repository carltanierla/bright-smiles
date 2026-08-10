# Step 1: Build the Inertia Vue assets
FROM node:20 AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
ARG VITE_APP_NAME="Laravel"
ENV VITE_APP_NAME=$VITE_APP_NAME
RUN npm run build

# Step 2: Set up the PHP / Nginx production environment
FROM php:8.3-fpm-alpine

# Install system extensions and PHP extensions needed for Laravel
RUN apk add --no-cache nginx supervisor mariadb-client postgresql-dev libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd zip bcmath

WORKDIR /var/www/html
COPY . .

# Copy compiled Vue assets from frontend-builder stage
COPY --from=frontend-builder /app/public/build ./public/build

# Install Composer packages
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set up permissions for Laravel storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx config
COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["sh", "-c", "nginx && php-fpm"]
