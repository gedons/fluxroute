FROM php:8.2-fpm

# Set working directory for the Laravel app
WORKDIR /var/www/html

# Copy the Laravel source code
COPY . /fluxroute

# Install PHP dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql zip gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install

# Expose port 80 for Laravel
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]