# Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Evitar diálogos interactivos durante la instalación de paquetes
ENV DEBIAN_FRONTEND=noninteractive

# Instalar dependencias del sistema, incluyendo gettext, locales, utilidades de compresión y git
RUN apt-get update && apt-get install -y \
    gettext \
    locales \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Generar y configurar localizaciones de idioma para gettext (Español e Inglés)
RUN sed -i -e 's/# es_ES.UTF-8 UTF-8/es_ES.UTF-8 UTF-8/' /etc/locale.gen && \
    sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && \
    locale-gen

# Establecer variables de entorno de localización por defecto
ENV LANG=es_ES.UTF-8
ENV LANGUAGE=es_ES:es
ENV LC_ALL=es_ES.UTF-8

# Instalar y habilitar extensiones PHP requeridas (PDO, PDO MySQL y Gettext)
RUN docker-php-ext-install pdo pdo_mysql gettext

# Habilitar el módulo rewrite de Apache (mod_rewrite) para soportar el routing dinámico del index.php
RUN a2enmod rewrite

# Copiar la herramienta Composer desde la imagen oficial para la gestión de dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el DocumentRoot de Apache para apuntar al directorio /public del proyecto
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto al contenedor
COPY . .

# Instalar las dependencias PHP requeridas con Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Ajustar los permisos de propiedad de los archivos para el usuario de Apache (www-data)
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto estándar HTTP (80)
EXPOSE 80
