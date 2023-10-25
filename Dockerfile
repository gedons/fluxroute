# Use the official PHP image as a base image
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel application files into the container
COPY . .erdy

# Install Composer dependencies
RUN composer install --no-dev

# Set appropriate permissions for storage and bootstrap cache directories
RUN chmod -R 775 storage bootstrap/cache

# Expose port 9000 (the default PHP-FPM port)
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]
