# Start from official PHP with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system packages and PostgreSQL-related PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libxml2-dev libicu-dev libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql intl

# Enable Apache rewrite module (important for CI4 routing)
RUN a2enmod rewrite

# Copy application code into the container
COPY . /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose HTTP port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
