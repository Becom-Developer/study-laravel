# study-laravel

laravel 学習用

## Environment

初動時の環境構築に関するメモ

類似のシステムを構築する場合の資料として活用してください。

### Docker

- 事前に docker を導入して使えるようにしておく
  - 参考: <https://docs.docker.com/get-docker/>

docker 起動用のファイルを用意、 内容は下記 `Files` 参照

```bash
touch Dockerfile docker-compose.yml
```

docker でイメージからコンテナ立ち上げまで

```bash
docker volume create mysql_study
docker-compose up --build
```

もうひとつコンソール立ち上げ、docker コンテナの中で laravel の最新をインストール

```bash
docker-compose exec web composer create-project laravel/laravel study-laravel
```

ディレクトリ構造を整える

```bash
mv -n study-laravel/* .
mv -n study-laravel/.[^\.]* .
```

README.md だけが残るがこれは今回は不要としておく、その後ディレクトリごと削除

```bash
rm -r study-laravel
```

初動のインストールなので `.env` ファイルは存在している db設定は下記のようにしておく

```text
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=forge
DB_USERNAME=forge
DB_PASSWORD=
```

表示のテスト: `http://localhost:8100/`

- データベース `phpmyadmin` 設定
  - 一通りイメージからコンテナ立ち上げまで終わると phpmyadmin が使えるのでwebブラウザで確認
  - <http://localhost:8200>
  - phpmyadminでデータベースのユーザーを作成
  - データベース「forge」は自動で作成される
  - 照合順序が標準の「utf8mb4_0900_ai_ci」でDATABASE 「forge」が作成されいるのを確認
  - ユーザーアカウント作成、ユーザー名「forge」を作成、パスワードなし、権限は全て許可

マイグレーション実行、テーブル作成

```bash
docker-compose exec web php artisan migrate
```

- laravel: <http://localhost:8100>
- phpmyadmin: <http://localhost:8200>

### Files

`Dockerfile`

```docker
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
```

`docker-compose.yml`

```yml
version: '3.9'
services:
  web:
    container_name: ctr-study-laravel
    build:
      context: .
    image: img-study-laravel
    ports:
      - '8100:80'
    volumes:
      - .:/usr/src/app
  db:
    container_name: ctr-study-laravel-db
    image: mysql:8.0.31
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: study
      MYSQL_DATABASE: forge
      MYSQL_USER: forge
    volumes:
      - mysql_study:/var/lib/mysql
  phpmyadmin:
    container_name: ctr-study-laravel-phpmyadmin
    image: phpmyadmin:5.2.0-apache
    restart: always
    ports:
      - 8200:80
    environment:
      PMA_HOST: 'db'
      PMA_USER: 'root'
      PMA_PASSWORD: 'study'

volumes:
  mysql_study:
    external: true
```
