FROM php:8.2-apache

# Python ve Pillow için gerekli araçları yükle
RUN apt-get update && apt-get install -y python3 python3-pip
RUN pip3 install Pillow --break-system-packages

# Proje dosyalarını sunucuya kopyala
COPY . /var/www/html/

# Apache port ayarı
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

WORKDIR /var/www/html/
