# Koristi PHP sa Apache-om
FROM php:8.2-apache

# Kopiraj sve fajlove u Apache folder
COPY . /var/www/html/

# Omogući potrebne PHP ekstenzije (ako zatrebaš)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache izložen port
EXPOSE 8080

# Fly.io koristi PORT iz env varijable, pa premapiraj
CMD ["apache2-foreground"]
