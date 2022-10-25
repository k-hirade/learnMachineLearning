FROM php:5.6.39-fpm-stretch
RUN apt-get update -y \
    && apt-get install -y \
    apt-utils \
    libfreetype6-dev \
    libmcrypt-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libcurl4-gnutls-dev \
    mysql-server \
    mysql-client \
    && rm -f /var/run/mysqld/mysqld.sock \
    && rm -f /tmp/mysql.sockrm -f /tmp/mysql.sock \
    && /etc/init.d/mysql start \
    && sleep 10 \
    && mysql -u root -e "create database test DEFAULT CHARACTER SET utf8mb4;grant all on test.* to test@localhost identified by 'password'" \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    && docker-php-ext-install -j${NPROC} \
    curl \
    dom \
    mbstring \
    mcrypt \
    pdo \
    pdo_mysql \
    simplexml \
    gd \
    && curl -sS https://getcomposer.org/installer | php -- --version=1.10.15 \
    && mkdir -p /var/run/php-fpm

COPY ./ /usr/share/nginx/html/cakephp/

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && echo "date.timezone = Asia/Tokyo" >> /usr/local/etc/php/php.ini

VOLUME ["/var/run/php-fpm"]
