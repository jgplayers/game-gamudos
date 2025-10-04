# Usa imagem com PHP e Apache prontos
FROM php:8.2-apache

# Copia todos os arquivos do projeto para o servidor
COPY . /var/www/html/

# Habilita módulos necessários do PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expõe a porta 80 (Render usa essa por padrão)
EXPOSE 80
