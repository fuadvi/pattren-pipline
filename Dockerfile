FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Add docker_backup php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo pdo_pgsql exif zip gd

COPY . .

EXPOSE 8080

ENTRYPOINT ["php","artisan", "serve"]
