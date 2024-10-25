FROM php:8.0-fpm

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Копируем файлы API
COPY . /var/www/html

WORKDIR /var/www/html

# Открываем порт для FPM
EXPOSE 9000
