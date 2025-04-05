FROM php:8.4.5

RUN apt-get update && apt-get install -y openssl zip unzip git libonig-dev libpq-dev \
    && docker-php-ext-install -j$(nproc) pdo_pgsql pgsql mbstring \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && echo memory_limit=512M >> /usr/local/etc/php/conf.d/php.ini

WORKDIR /application
CMD php artisan serve --host=0.0.0.0 --port=8000

RUN echo "alias a='php artisan --no-ansi '" >> /root/.bashrc

#RUN pecl install xdebug
