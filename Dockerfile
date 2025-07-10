FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install intl pdo pdo_pgsql pgsql

# Set working directory
WORKDIR /var/www/html

# Copy app code
COPY . /var/www/html

# Copy Apache config for index.php rewrites
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose HTTP port
EXPOSE 80
