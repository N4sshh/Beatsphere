# Use the official PHP-Apache image
FROM php:8.2-apache

# Copy project files to the web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite
