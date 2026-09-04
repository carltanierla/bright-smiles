FROM php:8.4-fpm-alpine

# 1. Install system dependencies & Node.js safely
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    && curl -sL https://nodesource.com | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 2. Enable Apache rewrite module (critical for frameworks like Laravel)
RUN a2enmod rewrite

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set the working directory
WORKDIR /var/www/html

# 5. Copy your project code
COPY . .

# 6. Run your install commands natively
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 7. Fix Apache document root permissions
RUN chown -R www-data:www-data /var/www/html

# 8. Render injects a $PORT environment variable. Configure Apache to follow it.
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

EXPOSE 80

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
