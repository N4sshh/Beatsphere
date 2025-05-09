# Use the official PHP-Apache image
FROM php:8.2-apache

# Copy project files from the Beatsphere folder to the web root
COPY . /var/www/html/

# Change the DocumentRoot to point to the "Group BeatSphere" folder (inside /var/www/html/)
RUN echo "DocumentRoot /var/www/html/Group\ BeatSphere" >> /etc/apache2/sites-available/000-default.conf

# Ensure index.php is recognized as the default index file
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

# Set correct permissions on the web root
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
