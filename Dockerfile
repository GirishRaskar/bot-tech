# ✅ Start from official PHP with Apache
FROM php:8.2-apache

# ✅ Set working directory
WORKDIR /var/www/html

# ✅ Install required system and PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libxml2-dev libicu-dev libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql intl

# ✅ Enable Apache rewrite module
RUN a2enmod rewrite

# ✅ Copy project files into container (CodeIgniter root)
COPY . /var/www/html

# ✅ Set correct file permissions for writable and system dirs
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

# 🔒 Optional: secure permissions for cache, logs, uploads, etc.
RUN chown -R www-data:www-data /var/www/html/public \
    && chmod -R 755 /var/www/html/public

# ✅ Apache config override to allow .htaccess (important!)
# This replaces default config to allow URL rewriting
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>' > /etc/apache2/conf-available/override.conf \
    && a2enconf override

# ✅ Expose HTTP port
EXPOSE 80

# ✅ Start Apache in foreground
CMD ["apache2-foreground"]
