FROM phpswoole/swoole:4.8-php8.0

WORKDIR /var/www/slim-app
RUN \
    apt-get update && \
    apt install libsqlite3-dev && \
    pecl update-channels        && \
    docker-php-ext-install pcntl && \
    # pecl install redis          && \
    # docker-php-ext-enable redis && \
    docker-php-ext-install pdo pdo_mysql pdo_sqlite    \