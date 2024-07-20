FROM php:8.1-fpm
 
# Set working directory
WORKDIR /var/www/html/
 
# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl \
    mariadb-client

# Install npm 
RUN apt-get update && apt-get install -y npm && npm install -g n && npm install -g npm@latest

RUN n lts

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
 
# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install phpredis extension to use redis as queue server for laravel project
RUN curl https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar --output pickle.phar && chmod +x pickle.phar && mv pickle.phar /usr/bin/pickle
RUN pecl install igbinary && docker-php-ext-enable igbinary
RUN pecl install redis && docker-php-ext-enable redis

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-install pcntl
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install supervisor cron -y
COPY ./start-container.sh /usr/bin/start-container
RUN chmod +x /usr/bin/start-container

RUN useradd -u1000 docker_app_user
RUN adduser www-data docker_app_user
RUN mkdir /home/docker_app_user
RUN chown -R docker_app_user:docker_app_user /home/docker_app_user

RUN echo "* * * * * root php /var/www/html/artisan schedule:run >> /var/www/html/storage/logs/cron.log 2>&1" >> /etc/crontab

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
# CMD [ "php-fpm" ]
ENTRYPOINT ["start-container" ]
