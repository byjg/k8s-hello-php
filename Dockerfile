FROM byjg/php:7.3-fpm-nginx

ENV PHP_CONTROLLER="/app.php"
ENV VERBOSE="true"
ENV NGINX_ROOT="/srv"

WORKDIR /srv

COPY app.php .
COPY composer.json .
RUN composer install
