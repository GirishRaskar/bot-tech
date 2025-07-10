# Start from official PHP with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install required packages
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libxml2-dev libicu-dev libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql intl

# Enable Apache rewrite module (for CI4 pretty URLs)
RUN a2enmod rewrite

# Copy application code into container
COPY . /var/www/html

# Fix permissions for CodeIgniter 4's writable directory
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
