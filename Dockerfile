FROM php:8.2-apache

# Define las variables de entorno para la base de datos usando ARG
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD


# Instala las dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    zlib1g-dev \
    libpng-dev \
    libpq-dev \
    libicu-dev \
    libxslt1-dev \
    g++ \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    librabbitmq-dev \
    libssh-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones de PHP
RUN docker-php-ext-install zip pdo_mysql gd pdo_pgsql intl xsl opcache mysqli pdo pdo_mysql soap

# Instala APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Instala extensiones adicionales
RUN pecl install amqp && docker-php-ext-enable amqp

# Configura Apache
RUN a2enmod rewrite

# Copia el código de tu aplicación Laravel al directorio /var/www/html
COPY . /var/www/html

# Configura el directorio de trabajo
RUN mkdir -p /var/www/scomputacion
RUN rm -r /var/www/html
WORKDIR /var/www/scomputacion
COPY ./comandos.txt /home/comandos.sh
RUN chmod +x /home/comandos.sh

# Ejecutar composer install
RUN composer install

# Ejecutar comandos de Artisan de Laravel
RUN php artisan migrate:fresh --seed
RUN php artisan key:generate
RUN php artisan optimize:clear


# Expone el puerto 80 para que puedas acceder a la aplicación desde tu navegador
EXPOSE 80

# Inicia Apache cuando se inicia el contenedor
CMD ["apache2-foreground"]
