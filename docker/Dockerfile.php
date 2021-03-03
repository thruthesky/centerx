FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql mysqli exif

# GD 를 설정하려면, 아래와 같이 해야 한다.
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


# 환경 설정 파일을 실제의 것으로 복사한다.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

