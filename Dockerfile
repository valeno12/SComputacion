FROM php:8.2-apache

# Instala las dependencias necesarias para Laravel
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip && \
    docker-php-ext-install zip pdo_mysql && \
    a2enmod rewrite && \
    service apache2 restart
RUN apt-get install -y git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y zlib1g-dev libpng-dev
RUN docker-php-ext-install gd
# Copia el código de tu aplicación Laravel al directorio /var/www/html
COPY . /var/www/html

# Configura el directorio de trabajo
RUN mkdir -p /var/www/scomputacion
RUN a2enmod rewrite
WORKDIR /var/www/scomputacion
RUN rm -r /var/www/html
COPY ./comandos.txt /home/comandos.sh
RUN chmod +x /home/comandos.sh
# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd
    
RUN apt-get update \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

RUN apt-get install -y zlib1g-dev g++ git libicu-dev libxslt1-dev\
    && docker-php-ext-install intl \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install xsl

RUN apt-get update \
    && docker-php-ext-install opcache

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN apt-get update && \
    apt-get install -y libxml2-dev \
    && docker-php-ext-install soap

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#CMD ["/home/comandos.sh"]
# Expone el puerto 80 para que puedas acceder a la aplicación desde tu navegador
EXPOSE 80

# Inicia Apache cuando se inicia el contenedor
CMD ["apache2-foreground"]
