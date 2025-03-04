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

ENV DB_CONNECTION=mysql
ENV DB_HOST=62.72.11.166
ENV DB_PORT=3306
ENV DB_DATABASE=economizai
ENV DB_USERNAME=db-agent-economizai
ENV DB_PASSWORD=economizai
ENV DB_DEBUG=true
ENV DB_DEBUG_BAD_QUERY=true
ENV SECRET_KEY=d6e4a9b6646c62fc48baa6dd6150d1f7
ENV ERROR_REPORTING=E_ALL
ENV ENVIRONMENT=app

EXPOSE 80

RUN composer install
CMD php-fpm -D && nginx -g "daemon off;"
