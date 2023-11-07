FROM php:8.1-fpm

WORKDIR /

RUN apt-get update && apt-get install -y git unzip libzip-dev

RUN docker-php-ext-install zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

WORKDIR /code

COPY . .

EXPOSE 9000

CMD ["php-fpm"]
