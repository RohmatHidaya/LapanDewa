FROM php:8.2-apache

# Install ekstensi PHP untuk Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan mod_rewrite (Laravel butuh)
RUN a2enmod rewrite

# Copy project Laravel
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Permission storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8080