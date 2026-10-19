FROM php:8.2-apache

# Instala as dependências necessárias para compilar extensões do PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Instala e ativa as extensões PDO e PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Copia os arquivos do projeto para a pasta pública do Apache
COPY . /var/www/html/

# Libera a porta 80
EXPOSE 80
