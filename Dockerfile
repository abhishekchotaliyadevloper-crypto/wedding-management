FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpq-dev libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_pgsql mbstring exif gd zip bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app

COPY . .

RUN composer install --no-dev --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD sh -c "php artisan migrate --force && \
php artisan storage:link && \
php artisan optimize:clear && \
(while true; do php artisan queue:work --sleep=3 --tries=3 --max-time=3600; echo 'Queue worker exited, restarting...'; sleep 1; done) & \
php artisan serve --host=0.0.0.0 --port=$PORT"
