FROM docker.io/dunglas/frankenphp:1-php8.4

RUN apt-get update \
 && apt-get install -y --no-install-recommends curl unzip \
 && rm -rf /var/lib/apt/lists/*
RUN install-php-extensions pdo_mysql redis intl zip opcache pcntl
COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/bin/composer

ENV SERVER_NAME=":80"
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev
