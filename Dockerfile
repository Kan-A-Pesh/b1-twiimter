FROM php:8.2.3-apache

# Copy apache config files
COPY conf/apache2.conf /etc/apache2/apache2.conf

# Copy php config files
COPY conf/php.ini /usr/local/etc/php/php.ini

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable apache modules
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start apache
CMD ["apache2-foreground"]
