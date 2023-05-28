FROM php:latest

WORKDIR /var/www/html

COPY ../ /var/www/html

RUN echo "date.timezone = UTC" >> /usr/local/etc/php/php.ini

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]
