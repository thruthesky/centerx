FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql mysqli gd

# 환경 설정 파일을 실제의 것으로 복사한다.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

