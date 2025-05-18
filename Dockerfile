FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
    nginx \
    php-mbstring \
    php-pdo_mysql \
    php-mysqli \
    php-intl \
    php-openssl \
    php-tokenizer \
    php-xml \
    php-curl \
    php-json \
    php-session \ 
    composer

RUN docker-php-ext-install pdo pdo_mysql mysqli

WORKDIR /usr/share/nginx/html

COPY . .
COPY default.conf /etc/nginx/http.d/default.conf

RUN chmod -R 777 /usr/share/nginx/html/.Log

EXPOSE 80

RUN composer install
CMD php-fpm -D && nginx -g "daemon off;"
