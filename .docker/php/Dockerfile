FROM php:7.4-fpm-alpine3.12

# install packages
RUN apk add --update \
    supervisor \
    git \
    zip \
    composer \
    postgresql-dev \
    libxml2-dev \
    autoconf

RUN docker-php-ext-install pdo pdo_mysql

COPY ./build/php/symfony.ini /etc/php7/conf.d/
COPY ./build/php/symfony.ini /etc/php7/cli/conf.d/
COPY ./build/php/xdebug.ini  /etc/php7/conf.d/

COPY ./build/php/symfony.pool.conf /etc/php7/php-fpm.d/

CMD ["php-fpm", "-F"]

WORKDIR /var/www/symfony
EXPOSE 9000
