FROM php:8.1.13-apache-bullseye
COPY --from=composer/composer:2-bin /composer /usr/bin/composer
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# apache 設定
ENV APACHE_DOCUMENT_ROOT /usr/src/app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# laravel インストール用
RUN apt update
RUN apt install -y git unzip

# gd ライブラリインストール用
RUN apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# 不足の php ライブラリ
RUN docker-php-ext-install sockets
RUN docker-php-ext-install exif
RUN docker-php-ext-install pdo_mysql

# ユーザーを作成後切り替え
RUN useradd -s /bin/bash -m -u 1000 appuser
USER 1000
