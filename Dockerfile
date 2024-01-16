# First stage: Create composer.json if not present
FROM alpine AS composer-setup
WORKDIR /app
RUN echo '{"require": {"php": "^8.2"}}' > composer.json

# Second stage: Composer install
FROM composer:2 AS composer
COPY --from=composer-setup /app /app
WORKDIR /app
RUN composer install --no-interaction --optimize-autoloader

# Third stage: Final image with only necessary files
FROM php:8.2-apache
WORKDIR /var/www/html
COPY --from=composer /app /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql
