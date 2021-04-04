# PHP 8.0.3 (최신버전) + FPM + Alpine 리눅스 조합
#
# 구성: PDO, MySQLi, GD, Exif
# 참고: gmp 설치를 위해서는 gmp-dev 가 필요하다.
#
FROM php:8.0.3-fpm-alpine

# RUN docker-php-ext-install 다음에 설치하고자 하는 모듈을 주욱 적어주면 된다.
RUN docker-php-ext-install pdo pdo_mysql mysqli exif

# GD2 설치.
RUN apk add --no-cache \
    freetype \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
        docker-php-ext-install -j${NPROC} gd && \
        apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

# 환경 설정 파일을 Production 의 것으로 복사한다.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

